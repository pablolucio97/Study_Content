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
## Handling dynamic navigation
1. Create the folder and parameterized file for resource you want to work as dynamic route. Example: create a router named products and a file called [id].tsx.
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