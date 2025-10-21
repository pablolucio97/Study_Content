# Handling routes with Expo Router
Expo Router was developed to make the navigation system implementation easier. Its work based on React Navigation traditional library.

## Features
- File route based. The structure of the folder and files determines the navigation of your app.
- Non existing routes will be renderized by not found file.
- Expo Router apps are cached and run offline-first with automatic updates when you publish a new version. 
- The app is able to handle incoming native URLS without depending a network connection.
- Its routes are type safety built. IT helps developer to work with valid routes.
- Routes are automatically optimized with lazy-evaluation being loaded on demand in production.
- Web application can be find be crawlers because it builds static files.

## Rules
- To be considered a route, the file must live inside the app folder and can be created directly on inside another folder. Example: profile.tsx or profile/index.tsx.
- The file must exports a React component.
- Each folder represents a segment of the URL path where index file represents the root of this segment.
- The file renderization preference order is: index.tsx > _layout.tsx
- "/" path redirects to initial path, home.

# Handling basic navigation
1. Create an index.tsx file inside the app folder. Example: 
```typescript
import { View } from "@/components/Themed";
import { Link } from "expo-router";

export default function Home() {
  return (
    <View>
      Home Screen
      <Link href="/profile">Go to Profile</Link>
      <Link href="/about">Go to About</Link>
    </View>
  );
}
```
2. Create a folder named profile with an index.tsx file, example:
```typescript
import { Link } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

export default function Profile() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Profile</Text>
      <Link href="/about">Go to About</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#da4c24",
  },
});
```

3. Create a folder named about with an index.tsx file, example:
```typescript
import { Link } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

export default function Profile() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Profile</Text>
      <Link href="/prrofile">Go to Profile</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#da4c24",
  },
});
```
## Handling dynamic navigation from different paths
1. Create the folder and parameterized file for resource you want to work as dynamic route. Example: create a router named products and a file called [...rest].tsx. Use useLocalSearchParams to extract the rest param.
```typescript
import { Link, useLocalSearchParams } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

export default function ProductDetail() {
  const { res } = useLocalSearchParams<{rest: string[]}>();
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Product Detail  from path {rest.join("/")}</Text>
      <Link href="/products">Go to Products</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#99eea9",
  },
});
```

2. Create the index for represent the collection of the list of resource to navigate dynamically. Example index.tsx:
```typescript
import { ExternalPathString, Link, RelativePathString } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

type Product = {
  id: number;
  name: string;
  href: RelativePathString | ExternalPathString;
};

export default function Profile() {
  const products: Product[] = [
    { id: 4, name: "Product 4", href: "/products/deals/playstation-5" as RelativePathString },
    { id: 5, name: "Product 5", href: "/products/electronics/playstation-5" as RelativePathString },
  ];

  return (
    <View style={styles.container}>
      <Text style={styles.text}>Products</Text>
      {products.map((product) => (
        <Link key={product.id} href={product.href}>
          {product.name}
        </Link>
      ))}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#da4c24",
  },
});

```

## Handling dynamic navigation
1. Create the folder and parameterized file for resource you want to work as dynamic route. Example: create a router named products and a file called [id].tsx.  Use useLocalSearchParams to extract the id param.
```typescript
import { Link, useLocalSearchParams } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

export default function ProductDetail() {
  const { id } = useLocalSearchParams();
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Product Detail - {id}</Text>
      <Link href="/products">Go to Products</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#99eea9",
  },
});
```

2. Create the index for represent the collection of the list of resource to navigate dynamically. Example index.tsx:
```typescript
import { ExternalPathString, Link, RelativePathString } from "expo-router";
import React from "react";
import { StyleSheet, Text, View } from "react-native";

type Product = {
  id: number;
  name: string;
  href: RelativePathString | ExternalPathString;
};

export default function Profile() {
  const products: Product[] = [
    { id: 1, name: "Product 1", href: "/products/1" as RelativePathString },
    { id: 2, name: "Product 2", href: "/products/2" as RelativePathString },
    { id: 3, name: "Product 3", href: "/products/3" as RelativePathString },
  ];

  return (
    <View style={styles.container}>
      <Text style={styles.text}>Products</Text>
      {products.map((product) => (
        <Link key={product.id} href={product.href}>
          {product.name}
        </Link>
      ))}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  text: {
    color: "#da4c24",
  },
});

```

## Rendering not found page
Not found page is useful to be shown when user hit a page that does not exists. To make it work create a file called "+not-found.tsx" under the app directory exporting a React component function.

## Using RootLayout
Use RootLayout together with Slot component (it's act like a children) to share consistent layout across screens. Example:
1. Create a file called `_layout.tsx` under app folder.
```typescript
import { Link, Slot } from "expo-router";
import { StyleSheet, Text, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function RootLayout() {
  return (
    <SafeAreaView style={styles.safeArea}>
      <View style={styles.header}>
        <Text style={styles.text}>Header</Text>
        <Link href="/">Home</Link>
      </View>
      <View style={styles.container}>
        <Slot />
      </View>
      <View style={styles.footer}>
        <Text style={styles.text}>Footer</Text>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
  },
  header: {
    width: "100%",
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    backgroundColor: "#4af8d58a",
    padding: 20,
  },
  container: {
    flex: 1,
    height: "100%",
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#cdcdcd",
  },
  text: {
    fontSize: 20,
    fontWeight: "bold",
  },
  footer: {
    width: "100%",
    backgroundColor: "#2eaafd",
    padding: 20,
    position: "absolute",
    bottom: 0,
  },
});

```
2.Create an index.tsx file to be render as the first item of the application. Example:
```typescript
import { Link } from "expo-router";
import { View, StyleSheet } from "react-native";

export default function Home() {
  return (
    <View style={styles.container}>
      Home Screen
      <Link href="/profile">Go to Profile</Link>
      <Link href="/about">Go to About</Link>
      <Link href="/products">Go to Products</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    width: "100%",
    justifyContent: "center",
    alignItems: "center",
  },
});
```

## Using nested layout for specific routes.
If you need to use an specific layout for a some screens. Put all these screens on the same folder and add a `_layout.tsx` file. These routes will be rendered over this layout instead of the default layout. Example:

1. Create a file called `_layout.tsx` under folder that contains that screens that will be displayed over the new layour.
```typescript
import { Link, Slot } from "expo-router";
import { StyleSheet, Text, View } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

export default function ProductsLayout() {
  return (
    <SafeAreaView style={styles.safeArea}>
      <View style={styles.header}>
        <Text style={styles.text}>Header</Text>
        <Link href="/">Home</Link>
      </View>
      <View style={styles.container}>
        <Slot />
      </View>
      <View style={styles.footer}>
        <Text style={styles.text}>Footer</Text>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
  },
  header: {
    width: "100%",
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    backgroundColor: "#4af8d58a",
    padding: 20,
  },
  container: {
    flex: 1,
    height: "100%",
    justifyContent: "center",
    alignItems: "center",
    backgroundColor: "#cdcdcd",
  },
  text: {
    fontSize: 20,
    fontWeight: "bold",
  },
  footer: {
    width: "100%",
    backgroundColor: "#2eaafd",
    padding: 20,
    position: "absolute",
    bottom: 0,
  },
});

```
2.Create an index.tsx file to be render as the first item of the application. Example:
```typescript
import { Link } from "expo-router";
import { View, StyleSheet } from "react-native";

export default function Home() {
  return (
    <View style={styles.container}>
      Home Screen
      <Link href="/profile">Go to Profile</Link>
      <Link href="/about">Go to About</Link>
      <Link href="/products">Go to Products</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    width: "100%",
    justifyContent: "center",
    alignItems: "center",
  },
});
```

## Using nested layouts

To use a nested layout simply create a _layout.tsx.file inside the route folder you want to nest the layout and these screen will be displayed with the custom layout nested inside basic general layout.

## Group Routes
Group routes are useful to navigate to a specific group of routes using the base path without affecting the url structure. For example: you can access the routes /login or /registration direct from the base path instead /auth/login or /auth/registration. To do it simply create a folder naming it inside parentheses, example: (auth).

Having a _layout.tsx file inside the folder will keep a layout for these screens, but still nested inside the root layout, at least all screens are separated into groups.

## Imperative navigation
Use router function from expo-router to navigate imperatively. Example:
```typescript
import { router } from "expo-router";
import { Button } from "react-native";

export default function Home() {
  return (
    <View style={styles.container}>
      <Button title="Login" onPress={() => router.push("/login")} />
    </View>
  );
}

```

## Using Redirect component
Use Redirect component to handle redirection. Example:
```typescript
    const isAuthenticated = false;

    if (!isAuthenticated) {
      return <Redirect href="/login" />;
    }

```

## Using Stack to handle stack navigation

```typescript
import { Stack } from "expo-router";
import { Image } from "react-native";

function ImageLogo() {
  return (
    <Image
      source={require("../../assets/images/favicon.png")}
      style={{ width: 30, height: 30, marginRight: 12 }}
    />
  );
}

export default function RootLayout() {
  return (
    <Stack>
      <Stack.Screen
        name="index"
        options={{
          title: "Home",
          headerTitleStyle: { fontWeight: "bold" },
          headerStyle: { backgroundColor: "#f4511e" },
          headerTintColor: "#fff",
        }}
      />
      <Stack.Screen
        name="about"
        options={{
          title: "About",
          headerTitleStyle: { fontWeight: "bold" },
          headerStyle: { backgroundColor: "#1e54f4" },
          headerTintColor: "#fff",
          headerRight: () => <ImageLogo />,
        }}
      />
    </Stack>
  );
}

```
## Using Tab to handle tabs navigation

```typescript
import FontAwesome from "@expo/vector-icons/FontAwesome";
import { Link, Tabs } from "expo-router";

export default function TabsLayout() {
  return (
    <Tabs
      screenOptions={{
        tabBarShowLabel: true,
        tabBarActiveTintColor: "#55EEE3",
        tabBarInactiveTintColor: "#e989ee",
        headerRight: () => <Link href="/">Home</Link>,
        headerStyle: {
          backgroundColor: "#71015b",
          paddingVertical: 24,
          paddingRight: 40,
          marginTop: 82
        },
      }}
    >
      <Tabs.Screen
        name="tab-one"
        options={{
          title: "Tab One",
          tabBarIcon: () => <FontAwesome name="address-book" />,
        }}
      />
      <Tabs.Screen
        name="tab-two"
        options={{
          title: "Tab Two",
          tabBarIcon: () => <FontAwesome name="adjust" />,
        }}
      />
    </Tabs>
  );
}
```

## Handling Drawer Navigation:
1. Install the required  running `npx expo install @react-navigation/drawer react-native-gesture-handler react-native-reanimated`.
2. Create a folder named (drawer).
3. Create the file representing routes to be navigated.
4. Create a _layout.tsx file, example:
```typescript
import FontAwesome from "@expo/vector-icons/FontAwesome";
import { Drawer } from "expo-router/drawer";
import { GestureHandlerRootView } from "react-native-gesture-handler";

export default function RootLayout() {
  return (
    <GestureHandlerRootView>
      <Drawer>
        <Drawer.Screen
          name="dashboard"
          options={{
            title: "Dashboard",
            drawerLabel: "Dashboard label",
            headerStyle: { backgroundColor: "#7e350d" },
            headerTintColor: "#fff",
            drawerIcon: () => (
              <FontAwesome name="dashboard" size={24} color="#3c39e8" />
            ),
          }}
        />
        <Drawer.Screen
          name="settings"
          options={{
            title: "Settings",
            drawerLabel: "Settings label",
            headerStyle: { backgroundColor: "#ae94cb" },
            headerTintColor: "#fff",
            drawerIcon: () => (
              <FontAwesome name="cog" size={24} color="#3c39e8" />
            ),
          }}
        />
      </Drawer>
    </GestureHandlerRootView>
  );
}
```


## General Tips
- At working with Expo Router, separate all screens into its group and have a specific layout for each group. Keep a _layout.tsx file for each group.
- Use Link to wrap text and Link with asChild prop with a Pressable to work as button for navigation. 
- Use relativeToDirectory when you want simple “go deeper inside this section” links like "settings" to resolve under the current folder (e.g., /account/settings).
- Use router.replace to replace the current screen on navigation state. It's very useful when user authenticates and should not be redirected to auth screen at clicking on go back. 
- To render a nested navigation simple render a navigation inside another. Example: You can render a  TabNavigation inside a StackNavigation simply keeping a route that render a TabNavigation layout inside your StackNavigation.


