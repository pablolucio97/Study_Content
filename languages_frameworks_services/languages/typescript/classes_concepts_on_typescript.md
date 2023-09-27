# CLASSES CONCEPTS ON TYPESCRIPT

## Type of Methods

### Static methods:
Static methods are associated with the class itself rather than its instances (objects). They can be called inside their own class without instantiating a new class. Static methods are useful for defining utility functions or operations that are not tied to any particular instance.

### Public methods:
Public methods are accessible from both inside and outside the class. They can be called on instances of the class as well as on the class itself. Public methods can access both instance-specific properties and other public methods of the class. By default, all methods defined within a class are public (unless marked as private or static).

### Private methods:
Private methods are only accessible from within the class where they are defined, and they cannot be accessed or called from outside the class, including instances of the class or subclasses. Private methods can access private properties and other private methods within the class.

### Abstract method:
A class that contains the abstract method in its declaration cannot be instantiated. To use this class in the future, it must be extended.

## Getters and Setters
Getters and Setters act like doors on our class to protect our class from changes and allow validation over each property of the class before exposing it. 

- A **getter** can be used to return a property of a class or create a new one.
- A **setter** can be used to modify a property of a class when needed. It is advised to create a setter only when you need to modify a class property.

### Complete class example:
```typescript
class UserManager {
    private static users: string[] = [];

    public static addUser(user: string): void {
        if (user) {
            this.users.push(user);
            console.log(`${user} has been added.`);
        } else {
            console.log("Invalid user.");
        }
    }

    private static listUsers(): void {
        console.log("Listing all users:");
        this.users.forEach(user => console.log(user));
    }

    private static _canListUsers: boolean = false;

    public static get canListUsers(): boolean {
        return this._canListUsers;
    }

    public static set canListUsers(value: boolean) {
        this._canListUsers = value;
    }

    public static tryListUsers(): void {
        if (this.canListUsers) {
            this.listUsers();
        } else {
            console.log("You do not have permission to list users.");
        }
    }
}

// Usage
UserManager.addUser("John Doe");
UserManager.tryListUsers(); // Will not list users as canListUsers is false by default
UserManager.canListUsers = true; // Setting canListUsers to true
UserManager.tryListUsers(); // Will list users as canListUsers is true

```
## General Tips

The dependency inversion concept is applied when a class receives another class as in its constructor and not is istancing it through new Class().
