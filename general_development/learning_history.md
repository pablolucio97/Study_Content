# Learning and experience's tips history

### 09/04/2024

- Always give an user return on if clauses, specially handling requests.
- Always put all variables related an function/method used in a useEffect inside this useEffect or add it as dependency.

---

### 10/04/2024

- On React Native projects, before sending any changes to production using Expo Updates, check if your local repository is 100% aligned with is expecting on production. Double check environment variables, current changes.
- Expo Updates can revert updates properly at deleting updates on production if something get wrong.

---

### 11/04/2024

- Use the flag -m to rename your current git branch. Example: git branch -m release1.5.15

---

### 12/04/2024

- If you're trying to merge objects on Javascript and it is not working as expected. Try to assign the merged object appointing the name of the updated property. Example:

```
const mergedConfigs = { ...objetoOutrasConfigsAtual, ...outras_configs };
Object.assign(updateConfig, { outras_configs: mergedConfigs });
```

- At working with a large variety of params, mainly on back-ends projects, prefer to receive these params inside an object because it is the more appropriated format expected to perform updates correctly.

- On back-end projects, if you wrap the code operations inside a try catch block the log will appear on the terminal instead of on a REST client.

---

### 15/04/2024

- At working with Styled Components and TypeScript, if you're facing typing issues related to application theme. Create an interface strictly equal to the interface you have extended on Styled Components. Probably you'll need to have two interfaces. One to extends Styled Components and another one to type your styles.

---

### 16/04/2024

- If your React Native application's log is not being show on Visual Studio terminal, try to initialize the Metro Bundler on Visual Studio Code terminal using the command `npx react-native start` before start the application.

---

### 17/04/2024

- On TypeScript you can use strings as properties keys typing. It's useful when you need to handle data where the object property is an unusual string instead of a commomn key. Example:

```typescript
fields: {
    taxa_juros: {
        value: string;
    },
    prazo_meses_card: {
        value: string;
    },
    'Encerramento da Oferta' : {
        value: string
    },
    'Valor' : {
        value: number
    }
}

const endDateField = investment.fields['Encerramento da Oferta'];
    if (endDateField?.value) {
        ccbEndDate = endDateField.value as string;
    }

    const valueField = investment.fields['Valor'];
    if (valueField?.value) {
        ccbValue = Number(valueField.value);
    }

```

---

### 19/04/2024

- Explore as much as possible the SQL methods and operations at working with ORMs. You can use SQL operations instead creating new functions. The example below can substitute a function for check if an user if over eighteen or not:

```sql
-- check if user data_nascimento < 18 and returns 1 if true or 0 if not
Sequelize.literal("IF(TIMESTAMPDIFF(YEAR, bigid_buybye.data_nascimento, CURDATE()) < 18, 1, 0)"),
```
