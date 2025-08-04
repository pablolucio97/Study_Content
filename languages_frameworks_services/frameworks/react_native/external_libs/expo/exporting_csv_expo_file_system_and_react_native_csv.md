# Exporting CSV Files in React Native with Expo

This tutorial demonstrates how to export and save CSV files in a React Native application using the `expo-file-system` and `react-native-csv` libraries.

## 📦 Dependencies

Install the required packages:

```bash
expo install expo-file-system
yarn add react-native-csv
```

## 🧠 Overview

We'll convert a JSON object into CSV format and save it using Android's SAF (Storage Access Framework).

## 💡 Step-by-Step Guide

### 1. Prepare JSON Data

```ts
const jsonData = [
  {
    id: "ee9cc85a-9a6d-4071-9d5d-195734b9082b",
    service: "Youtube",
    login_or_email: "pablo@test.com",
    user_id: "586fb5ee-4ffb-4852-92c2-ce197925fddd",
    password: "abc123",
  },
  {
    id: "1d0920d5-219c-4652-9e8d-d88c1d5b2a2e",
    service: "Babaloo",
    login_or_email: "pablo@test.com",
    user_id: "586fb5ee-4ffb-4852-92c2-ce197925fddd",
    password: "123456@123",
  },
];
```

### 2. Convert JSON to CSV

```ts
import { jsonToCSV } from 'react-native-csv';

const csvData = jsonToCSV(jsonData);
```

### 3. Save CSV File with `expo-file-system`

```ts
import * as FileSystem from 'expo-file-system';

const { StorageAccessFramework } = FileSystem;

const permissions = await StorageAccessFramework.requestDirectoryPermissionsAsync();
if (!permissions.granted) return;

const uri = await StorageAccessFramework.createFileAsync(
  permissions.directoryUri,
  'MyDataExport',
  'text/csv'
);

await FileSystem.writeAsStringAsync(uri, csvData, { encoding: FileSystem.EncodingType.UTF8 });
```

### 4. Full Example Component

```tsx
import React from 'react';
import { Button } from 'react-native';
import * as FileSystem from 'expo-file-system';
import { jsonToCSV } from 'react-native-csv';

export function ExportCSV() {
  const handleSaveExportData = async () => {
    const jsonData = [
      {
        id: "ee9cc85a-9a6d-4071-9d5d-195734b9082b",
        service: "Youtube",
        login_or_email: "pablo@test.com",
        user_id: "586fb5ee-4ffb-4852-92c2-ce197925fddd",
        password: "abc123",
      },
      {
        id: "1d0920d5-219c-4652-9e8d-d88c1d5b2a2e",
        service: "Babaloo",
        login_or_email: "pablo@test.com",
        user_id: "586fb5ee-4ffb-4852-92c2-ce197925fddd",
        password: "123456@123",
      },
    ];

    const CSV = jsonToCSV(jsonData);
    const { StorageAccessFramework } = FileSystem;
    const permissions = await StorageAccessFramework.requestDirectoryPermissionsAsync();
    if (!permissions.granted) return;

    try {
      const uri = await StorageAccessFramework.createFileAsync(
        permissions.directoryUri,
        'MyData',
        'text/csv'
      );
      await FileSystem.writeAsStringAsync(uri, CSV, {
        encoding: FileSystem.EncodingType.UTF8,
      });
      alert('Exported Successfully!');
    } catch (error) {
      console.error('Export error:', error);
    }
  };

  return <Button onPress={handleSaveExportData} title="Export CSV" />;
}
```