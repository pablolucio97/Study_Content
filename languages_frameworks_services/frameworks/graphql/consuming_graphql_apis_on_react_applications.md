# Consuming GraphQL APIs on React applications

1. Create your React application.
2. Run `npm install @apollo/client graphql` to install GraphQL and Apollo dependencies.
3. Wrap your application with the Apollo client provider passing the back-end url to communicate with GraphQL. E.g:

```typescript
import { ApolloClient, ApolloProvider, InMemoryCache } from "@apollo/client";
import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import App from "./App.tsx";
import "./input.css";

const client = new ApolloClient({
  uri: "http://localhost:3333/graphql",
  cache: new InMemoryCache(),
});

createRoot(document.getElementById("root")!).render(
  <StrictMode>
    <ApolloProvider client={client}>
      <App />
    </ApolloProvider>
  </StrictMode>
);
```
4. Run `npm install -D @graphql-codegen/cli` to install GraphQL Code Gen cli and `npm install -D @graphql-codegen/typescript @graphql-codegen/typescript-operations @graphql-codegen/typescript-react-apollo` to install its dependencies to gen hooks based on your .graphql schema files.
5. Create a folder called `graphql`, and inside it a file.graphql containing queries and mutations for the entity you want to generate queries and mutations hooks. Example:
```graphql
  query GetUsers {
    getUsers {
      id
      name
      email
    }
  }


  query GetUser($data: GetUserInput!) {
    getUser(data: $data) {
      id
      name
      email
    }
  }

  mutation CreateUser($data: CreateUserInput!){
    createUser(data: $data){
      name
      email
    }
  }

  mutation DeleteUser($data: DeleteUserInput!){
    deleteUser(data: $data){
      id
    }
  }

  mutation UpdateUser($data : UpdateUserInput!){
	updateUser(data: $data){
		id
		name
	}
}

```
6. Run `npx graphql-codegen` to generate your queries and mutation hooks based on files with .graphql extensions.

7. Consume the hooks on your application according necessary. Complete CRUD consumption example:
```typescript
import { useCallback, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "../../components/Button";
import { Input } from "../../components/Input";
import UserCard from "../../components/UserCard";
import {
  useCreateUserMutation,
  useDeleteUserMutation,
  useGetUserLazyQuery,
  useGetUsersQuery,
  useUpdateUserMutation,
} from "../../generated/graphql";

const UsersScreen: React.FC = () => {
  const [userId, setUserId] = useState("");
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");

  const {
    data: usersData,
    loading: usersLoading,
    error: usersError,
    refetch: refetchUsers,
  } = useGetUsersQuery();
  const [
    getUser,
    { data: userData, loading: userLoading, error: userError, called },
  ] = useGetUserLazyQuery();

  const handleSelectUser = useCallback((userId: string) => {
    setUserId(userId);
  }, []);

  const handleFetchUser = useCallback(
    (userId: string) => {
      handleSelectUser(userId);
      getUser({
        variables: {
          data: {
            id: userId,
          },
        },
      });
    },
    [getUser, handleSelectUser]
  );

  const [
    createUser,
    {
      data: createUserData,
      loading: createUserLoading,
      error: createdUserError,
    },
  ] = useCreateUserMutation();

  const handleCreateUser = () => {
    createUser({
      variables: {
        data: {
          name,
          email,
        },
      },
      onCompleted: () => {
        console.log("User created successfully!", createUserData);
        refetchUsers();
      },
      onError: (error) => {
        console.log("Error at trying to create user: ", error);
      },
    });
  };

  const [
    deleteUser,
    {
      data: deleteUserData,
      error: deleteUserError,
      loading: deleteUserLoading,
    },
  ] = useDeleteUserMutation();

  const handleDeleteUser = useCallback(
    (userId: string) => {
      deleteUser({
        variables: {
          data: {
            id: userId,
          },
        },
        onCompleted: () => {
          console.log("User deleted successfully!", deleteUserData);
          refetchUsers();
        },
        onError: (error) => {
          console.log("Error at trying to create user: ", error);
        },
      });
    },
    [deleteUser, deleteUserData, refetchUsers]
  );

  const [
    updateUser,
    { data: updatedUser, error: updateUserError, loading: updateUserLoading },
  ] = useUpdateUserMutation();

  const loading =
    usersLoading ||
    userLoading ||
    createUserLoading ||
    deleteUserLoading ||
    updateUserLoading;
  const error =
    usersError ||
    userError ||
    createdUserError ||
    deleteUserError ||
    updateUserError;

  const handleUpdateUser = useCallback(() => {
    updateUser({
      variables: {
        data: {
          id: userId,
          name,
        },
      },
      onCompleted: () => {
        console.log("User updated successfully!", updatedUser);
      },
      onError: (error) => {
        console.log("Error at trying to create user: ", error);
      },
    });
  }, [name, updateUser, updatedUser, userId]);

  const navigate = useNavigate();

  const handleNavigatePhotos = () => {
    navigate("/photos");
  };

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error: {error.message}</p>;

  return (
    <div className="w-full flex flex-col p-8">
      <h1 className="text-gray-900 text-3xl font-bold">Users</h1>
      <div className="my-5">
        <Button label="Go to photos page" onClick={handleNavigatePhotos} />
      </div>
      <div className="flex flex-row">
        {/* List and get users */}
        <div className="flex flex-col border-r-2 pr-8">
          <h2 className="my-3 text-xl font-bold">List of users</h2>
          <ul className="mb-4">
            {usersData &&
              usersData.getUsers &&
              usersData.getUsers.map(
                (user: { id: string; name: string; email: string }) => (
                  <UserCard
                    key={user.id}
                    id={user.id}
                    name={user.name}
                    email={user.email}
                    onDelete={() => handleDeleteUser(user.id)}
                    onGet={() => handleFetchUser(user.id)}
                  />
                )
              )}
          </ul>

          {called && userData && userData.getUser && (
            <>
              <span className="my-3 text-xl font-bold">Single user</span>
              <div className="flex items-center">
                <p className="ml-3">{userData.getUser.name}</p>
                <p className="mx-3">{userData.getUser.email}</p>
              </div>
            </>
          )}
        </div>

        {/* Create user form */}
        <div className="flex flex-col border-r-2 px-8">
          <h2 className="my-3 text-xl font-bold">Create user</h2>
          <form onSubmit={handleCreateUser}>
            <div className="mb-2">
              <Input
                label="Name"
                value={name}
                onChange={(val) => setName(val.target.value)}
              />
            </div>
            <div className="mb-4">
              <Input
                label="Email"
                value={email}
                onChange={(val) => setEmail(val.target.value)}
              />
            </div>
            <Button
              label="Create user"
              type="submit"
              disabled={!email || !name}
            />
          </form>
        </div>

        {/* Update user form */}
        {userId && (
          <div className="flex flex-col px-8">
            <h2 className="my-3 text-xl font-bold">Update user</h2>
            <form onSubmit={handleUpdateUser}>
              <div className="mb-4">
                <Input
                  label="Name"
                  value={name}
                  onChange={(val) => setName(val.target.value)}
                />
              </div>

              <Button label="Update user" type="submit" disabled={!name} />
            </form>
          </div>
        )}
      </div>
    </div>
  );
};

export default UsersScreen;

```