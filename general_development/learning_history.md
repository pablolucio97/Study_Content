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
---

### 24/04/2024

- At working with React Native and applications where its possible to push updates without generating a new build, always maintain your main branch aligned what was sent to production, and always use the stage branch to merge new features. Only merge the stage into main at releasing a new version of the application to production.
  
- Always maintain a document history containing the content and the reason of the update of your project updates at working with React Native and applications where its possible to push updates.

---

### 27/04/2024

- At working with native Android files on React Native and applications, be careful to not duplicate properties or crash some native configuration because the inconsistency will be directly reflected in the build execution/generation (considering third services like EAS too) shown by Android as not clear errors.

- To remove the last commit from GitHub, run `git reset --hard HEAD~1` to back to the previous commit from the last one, and the run `git push origin <branch-name> --force` to force the removing.

---

### 30/04/2024

- At working with back-end applications related to CRUD operations, always export and provides the Insomnia request collection correctly configured containing the environment variables for the project.

---

### 02/05/2024

- At working with frameworks with requires file configurations like NestJS and Expo by example, and you're facing errors. Check the specific framework configuration for missing configurations of these frameworks. Generally a configuration file is created at the project root dir.

- At writing logics on JSX, nested logics followed by the `&&` operator must be wrapped in parentheses to take effect. Example:
```javascript   
(investmentDetailsRef.current.status === 'Liquidado' ||
investmentDetailsRef.current.status === 'Pago' ||
investmentDetailsRef.current.status === 'Processando')
&& <Text>My content</Text>
```
---

### 13/05/2024

- At working with data formation and conversion with Unix input, be careful to check the operation is using UTC (Coordinated Universal Time) whose doesn't is affected by server time zone.

- Be careful at using the ` ??` operator because it only take effect for validating undefined and null values.

- At pushing a commit to GitHub that has facing conflicts, be sure all files was sent to GitHub.

---

### 17/05/2024

- At contributing on team projects, and you need to update your branch with main, push your commit first otherwise you could accidentally lost all your code.

---

### 25/05/2024

- At stuck on an error, you must think in the code bright, it is the start and finish points of your code an try to solve the problem considering all points. Example: In a back-end project you should start thinking on the database credentials configuration, models and views (virtual tables based on complex queries) configurations, models importation and code usage, use cases, controllers, and finally routes and received requests. Here the database configuration is your start point and request receiving the last one.

- At working with databases, you can create views to store virtual tables containing complex queries. Some times it is useful to retrieve complex queries with more performance. Generally these virtual tables has different colors on the database management software.

- At working with node native modules that performs async operations like the libraries `fs` and `path` , wrap all operations under a promise, example:
  
---

### 28/05/2024

- Always check the type of data (if it's a function, class and so on) you're importing in your JavaScript/TypeScript files. Sometimes some documentations are not clear on how to use their API's.
