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

### 22/04/2024

- Understanding Sequelize relationships queries:

To perform Sequelize relationships queries first we need to define the relationship between two different models based on common record values present on both models, and then perform the query.

In this example below we'll determine a relationship between "Usuario" and "bigid_buybye" models where both models has the same records values presents in "identificacao" and "cpf" columns respectively.

```sql

    -- defines the relationship between the models declaring that each instance of "Usuario" is associated
    -- with an instance of "bigid_buybye" through "identificacao" column present on "Usuario" pointing to "cpf"
    -- column present on "bigid_buybye"
    TAB_Autenticacao.Usuario.belongsTo(TAB_Autenticacao.bigid_buybye, {foreignKey: 'identificacao', targetKey: 'cpf' });
    -- starts the query retriveing for a single record on "Usuario" model
      const menorDeIdade = await TAB_Autenticacao.Usuario.findOne({
    -- returns a single attribute "menor_de_idade" with the value based in the condition below
      attributes: [
      [
    -- calculates the age by comparing the data_nascimento (date of birth) from the bigid_buybye table with the
    -- current date (CURDATE()). If the result of TIMESTAMPDIFF(YEAR, bigid_buybye.data_nascimento, CURDATE())
    -- is less than 18, it returns 1, otherwise 0. where `Sequelize.literal` is used to perform raw queries
        Sequelize.literal("IF(TIMESTAMPDIFF(YEAR, bigid_buybye.data_nascimento, CURDATE()) < 18, 1, 0)"),
        'menor_de_idade'
      ]
      ],
    -- includes the bigid_model in the query returning it alls attributes
      include: [{
      model: TAB_Autenticacao.bigid_buybye,
      -- This ensures the SQL JOIN produced is an INNER JOIN, meaning the query will only return Usuario records that have
      -- a corresponding bigid_buybye record.
      required: true,
      --  Specifies that the "cpf" in "bigid_buybye" must match the "identificacao" column in the "Usuario" model for the join to happen.
      where: {
        cpf: Sequelize.col('Usuario.identificacao')
      }
      }],
      --  Filters the results of the main query (not the join) to records where the login_id_login field equals the id_login variable.
      where: {
      login_id_login: id_login
      }})
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
(investmentDetailsRef.current.status === "Liquidado" ||
  investmentDetailsRef.current.status === "Pago" ||
  investmentDetailsRef.current.status === "Processando") && (
  <Text>My content</Text>
);
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

### 07/06/2024

- At executing Docker's command be careful with the parameters order. It can affect directly the working of a container, image or volume.
- At creating entities on real applications, consider creating user and other actors cpf and birth date data for legal purposes.

### 17/06/2024

- JavaScript listener executes even if the variable associated with it doesn't is being used. Sometimes the listener should be called directly where the action will be called.

### 18/06/2024

- At working with timers on React, do not rely on the count state directly because it can cause renderization shifting. Rely on prevState/currentCount. Example:

Use

```typescript
useEffect(() => {
  const timer = setInterval(() => {
    setCount((currentCount) => {
      if (currentCount <= 1) {
        clearInterval(timer);
        signOut();
        return currentCount;
      }
      return currentCount - 1;
    });
  }, 1000);

  return () => {
    clearInterval(timer);
  };
}, [signOut]);
```

instead of using

```typescript
const redirectUser = useCallback(() => {
  const timer = setInterval(() => {
    setCount(count - 1);
  }, 1000);

  if (count <= 1) {
    signOut();
  }

  return () => {
    clearInterval(timer);
  };
}, [count, signOut]);

useEffect(() => {
  redirectUser();
}, [redirectUser]);
```

### 27/06/2024

- If images are not being shown on Android at working with react native. Try to run the build again using --reset-cache flag.

### 12/07/2024

- At mirroring refs from a component to another in React. The provider component must has a property typed as a MutableObjectRef<> to be consumed. Ref state must be initialized only in the consumer component through useRef().

### 20/07/2024

- If you're facing external libraries typing errors, try to extending it on a library.d.ts file if reinstalling libraries different versions does not works. Example:

```typescript
import { AccordionProps } from "@material-tailwind/react/components/Accordion";
import { AccordionBodyProps } from "@material-tailwind/react/components/AccordionBody";

declare module "@material-tailwind/react" {
  export const Accordion: React.FC<AccordionProps>;
  export const AccordionBody: React.FC<AccordionBodyProps>;
}
```

### 10/08/2024

- At working with delete operation on back-end and you're using NestJS, define the HttpCode as 200. Do not set it as 204 because it will return no data even if the code declares a return.

### 18/08/2024

- Some React Native Android projects needs a specific Java Version to run. To switch between Java versions using the jenv version management tool use this guid:

1 - Run `export PATH="$HOME/.jenv/bin:$PATH"
eval "$(jenv init -)"` to init jenv.

2 - Run `jenv global your_java_version` ex : `jenv global 17.0`.

3 - Run `java --version` to check the java version.

### 22/08/2024

- At doing verifications on your controller on back-end, always return different errors status code for each scenario. 400 for client bad request when user missing or mismatch some field or param, 409 when some back-end condition is not satisfied, and 404 when the resource is not found.
- At handling requests on your front-end, always relies on status code instead response messages if you trust on the back-end construction.
- At defining API's communication configurations, always create a pattern on its interceptors to return its responses and errors. Log each request for track your system efficiently. If possible, the back-end should have a standard response too. Have an interface for response errors and another one to response success where the response content must be dynamic through TypeScript's Generics. A good front-end communication configuration example is:

```typescript
import axios, {
  AxiosError,
  AxiosResponse,
  InternalAxiosRequestConfig,
} from "axios";

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_STAGE_BASEURL,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

interface IApiErrorResponse {
  RES: any;
  MSG: {
    message: string;
    error: string;
  };
  SUCCESS: boolean;
  TIMESTAMP: string;
  PATH: string;
  STATUS: number;
}

export interface IApiSuccessResponse<T> {
  RES: T;
  SUCCESS: boolean;
}

api.interceptors.request.use((config: InternalAxiosRequestConfig) => {
  const requestInfo = `[${config.method?.toUpperCase()}] - ${config.url}`;
  console.log(requestInfo);
  return config;
});

api.interceptors.response.use(
  (response: AxiosResponse<IApiSuccessResponse<any>>) => {
    console.log("[RESPONSE SUCCESS] - ", response.data);
    return response;
  },
  (error: AxiosError<IApiErrorResponse>) => {
    if (error.response) {
      console.log("[RESPONSE ERROR] - ", error.response.data);
      return Promise.reject(error.response.data);
    } else if (error.request) {
      console.log("[RESPONSE ERROR] - ", error.request.data);
      return Promise.reject(error.request.data);
    }
  }
);
```

### 23/08/2024

- Never allows duplicated keys at working with arrays on React, otherwise you can deal with headaches. If a key is duplicated, you can concatenate the key with the mapping index.

### 26/08/2024

- At configuring Axios API, avoid defining default headers because it can mismatch at performing multipart forms.

### 06/09/2024

- If you're struggling with late state updating related to listed components, try to call the current mapped item directly. Example, do:

```typescript
const handleDownloadCertificate = (certificate: ICertificateDTO) => {
  if (certificate) {
    window.location.href = certificate.url;
  }
};
{
  certificates.map((certificate) => (
    <CertificateCard
      onSelectCertificate={() => setSelectedCertificate(certificate)}
      onDownload={() => handleDownloadCertificate(certificate)}
    />
  ));
}
```

instead of

```typescript
  const handleDownloadCertificate = () => {
    if (selectedCertificate) {
      window.location.href = selectedCertificate.url;
  };
     {certificates.map((certificate) => (
    <CertificateCard
      onSelectCertificate={() => setSelectedCertificate(certificate)}
      onDownload={handleDownloadCertificate}
    />
    ))}

```

### 06/09/2024

- Alway ass possible, use git the command `git commit --amend -m 'the fixed message'` before pushing it to GitHub.
- Be careful on these points at performing request on your application for improving performance:

  1. If the data returned by the query will only be shown and not be handled hereafter, the you do not need a state and can just return then fetched data.
  2. If you're doing multiple requests, you can compare the queries performance doing it at once in a single function returning an object containing all fetched data or use `useQueries` to handle it separately.
  3. At doing chained requests where the first request fails, then you should return a null value to avoid process the next requests immediately.
  4. If you're using react query, use the study the possibility of using staleTime option to avoid unnecessary refetching.
     Example of a good multiple call handle in a single function:

  ```typescript
  const watchedClassesRepository = useMemo(() => {
    return new WatchedClassesRepository();
  }, []);

  const videoClassesRepository = useMemo(() => {
    return new VideoClassesRepository();
  }, []);

  const trainingMetricsRepository = useMemo(() => {
    return new TrainingMetricsRepository();
  }, []);

  const getCompleteInfo = useCallback(async () => {
    try {
      const watchedClasses =
        await watchedClassesRepository.listWatchedClassesByUser(user.id);
      const lastWatchedClass = watchedClasses.slice(-1)[0];

      if (!watchedClasses) return null;

      const lastWatchedClassInfo =
        await videoClassesRepository.getVideoClassById(
          lastWatchedClass.videoclass_id
        );

      if (!lastWatchedClassInfo) return null;

      const trainingMetrics =
        await trainingMetricsRepository.getTrainingMetricsByUserAndTraining({
          user_id: user.id,
          training_id: lastWatchedClassInfo.training_id,
        });

      return { lastWatchedClassInfo, trainingMetrics };
    } catch (error) {
      console.log(error);
    }
  }, [
    trainingMetricsRepository,
    user.id,
    videoClassesRepository,
    watchedClassesRepository,
  ]);

  useEffect(() => {
    getCompleteInfo();
  }, [getCompleteInfo]);

  const {
    data,
    error: hasError,
    isLoading,
  } = useQuery({
    queryKey: ["complete-info"],
    queryFn: getCompleteInfo,
    staleTime: 1000 * 60, // 1 minute,
  });

  const lastWatchedClassInfo: IVideoClassDTO | undefined =
    data?.lastWatchedClassInfo;
  const trainingMetrics: ITrainingMetricsDTO | undefined =
    data?.trainingMetrics;
  ```

### 11/09/2024

If you need to return different status errors on the back-end and you're using Nest, check for the instance type of each error and then throw it on the catch block. Example:

```typescript
try {
  //...your_code
} catch (error) {
  console.log("[INTERNAL ERROR]", error.message);

  if (error instanceof NotAcceptableException) {
    throw error;
  }

  throw new ConflictException({
    message:
      "An error occurred. Check all request body fields for possible mismatching. Check if the video you are trying to upload is working correctly, and if it has audio.",
    error: error.message,
  });
}
```

### 13/09/2024

If you need to perform a second request to complete data fetched from a first request, you can fetch for the first request, and using Promise.all, you can iterate calling the respective data for each item in the array. Example:

```typescript
useEffect(() => {
  const fetchTrainingsWithLastWatchedClass = async () => {
    const trainings = await getTrainings();

    if (trainings) {
      const trainingsWithLastWatchedClass = await Promise.all(
        trainings.map(async (training) => {
          const lastWatchedClass = await getLastWatchedClassesByTraining(
            training.id
          );
          return {
            ...training,
            last_watched_class_duration:
              lastWatchedClass?.videoclass?.duration ?? null,
            last_watched_class_name: lastWatchedClass?.videoclass?.name ?? null,
          };
        })
      );
      setTrainings(trainingsWithLastWatchedClass);
    }
  };

  fetchTrainingsWithLastWatchedClass();
}, [getLastWatchedClassesByTraining, getTrainings]);
```

### 21/09/2024

- At working with upload on clouds (Aws, Azure, and similar) always upload the file formatted, always upload it removing it spaces and accents to avoid another services mismatching file management.
- Have a validation to always remove the file when not more used on updates and deletion to avoid unnecessary charges.

### 08/10/2024

- At creating new screens on React Native, always define a SafeAreaProvider to show the screen style calculating the padding top to avoid content be shown competing space with status bar using the library `react-native-safe-area-context`. Example:

```typescript
import {
  Roboto_400Regular,
  Roboto_700Bold,
  useFonts,
} from "@expo-google-fonts/roboto";
import { StatusBar } from "expo-status-bar";
import { SafeAreaProvider } from "react-native-safe-area-context";
import { ThemeProvider } from "styled-components/native";
import { Loading } from "./src/components/Loading";
import { Routes } from "./src/routes";
import theme from "./src/theme";

export default function App() {
  const [fontLoaded] = useFonts({ Roboto_400Regular, Roboto_700Bold });

  if (!fontLoaded) {
    return <Loading />;
  }

  return (
    <ThemeProvider theme={theme}>
      <SafeAreaProvider>
        <StatusBar style="light" translucent backgroundColor="transparent" />
        <Routes />
      </SafeAreaProvider>
    </ThemeProvider>
  );
}
```

```typescript
import { Power } from "phosphor-react-native";
import React from "react";
import { TouchableOpacity } from "react-native";
import { useSafeAreaInsets } from "react-native-safe-area-context";
import theme from "../../../../theme";
import { Container, Greeting, Message, Name, Picture } from "./styles";
export function HomeHeader() {
  const insets = useSafeAreaInsets();

  const paddingTop = insets.top + 24;

  return (
    <Container style={{ paddingTop }}>
      <Picture
        source={{ uri: "https://github.com/rennand.png" }}
        placeholder="L184i9ofbHof00ayjsay~qj[ayj@" //generated placeholder for image from https://blurha.sh/
      />
      <Greeting>
        <Message>Olá</Message>
        <Name>Rodrigo</Name>
      </Greeting>
      <TouchableOpacity>
        <Power size={32} color={theme.COLORS.GRAY_400} />
      </TouchableOpacity>
    </Container>
  );
}
```

### 09/10/2024

- At adding a new plugin to your app.json on Expo projects, run `npx expo prebuild` to expo execute the required configurations on native code. You can do all configs your app needs inside app.json or app.config.json and then run `npx expo prebuild` to expo apply these configurations on the native code.
- If you need to use environment variables on app.json file, rename it to app.config.js, import dotenv and export the object using module.exports. Example:

```javascript
import * as dotenv from "dotenv";

dotenv.config();

module.exports = {
  expo: {
    name: "iginte-fleet",
    slug: "iginte-fleet",
    version: "1.0.0",
    orientation: "portrait",
    icon: "./assets/icon.png",
    userInterfaceStyle: "dark",
    splash: {
      image: "./assets/splash.png",
      resizeMode: "contain",
      backgroundColor: "#202024",
    },
    assetBundlePatterns: ["**/*"],
    ios: {
      supportsTablet: true,
      bundleIdentifier: "com.pablosilva.ignitefleet",
      config: {
        googleMapsApiKey: process.env.GOOGLE_MAPS_API_KEY,
      },
    },
    android: {
      adaptiveIcon: {
        foregroundImage: "./assets/adaptive-icon.png",
        backgroundColor: "#202024",
      },
      package: "com.pablosilva.ignitefleet",
      config: {
        googleMapsApiKey: process.env.GOOGLE_MAPS_API_KEY,
      },
    },
    web: {
      favicon: "./assets/favicon.png",
    },
    plugins: [
      [
        "expo-location",
        {
          locationAlwaysAndWhenInUsePermission:
            "Allow $(PRODUCT_NAME) to use your location.",
        },
      ],
    ],
  },
};
```

- At working with resources that needs user permissions, provide a button to user access his mobile settings easily, example:

```typescript
import { Linking, Platform } from "react-native";

export function openSettings() {
if (Platform.OS === "ios") {
 return Linking.openURL("app-settings:");
}
if (Platform.OS === "android") {
 return Linking.openSettings();
}
}
-
```

### 22/10/2024

- At facing build problems on NextJS projects, try correcting your css files using the stylelint library to check for mistakes, configuration and script, and if it did not work, try disabling webpack optimization minimization on your next.config file. Example:

```javascript
/** @type {import('next').NextConfig} */
const nextConfig = {
  webpack(config, { isServer }) {
    // Disable CSS minification for build the project
    config.optimization.minimize = false;
    return config;
  },
};
export default nextConfig;
```

- At facing TypeScript not recognizing JSX component error `Component cannot be used as a jsx component`, add the path to react types on your `tsconfig.json` file. Example:

```json
{
  "compilerOptions": {
    "jsx": "react",
    "strict": true,
    "paths": {
      "react": ["./node_modules/@types/react"]
    }
  }
}
```

### 25/10/2024

- At building models schemas, always pay attention on mapping all unique fields. Example: On a model called "company", the property "cnpj" and "social_reason" should be unique.
- At building models schemas, if you plan to perform a lot of queries based in a column you should consider indexing this column to improve impressive queries performance. Example: In this PrismaORM model, the email column will be used a lot of times in some queries.

```
model Company {
id            String     @id @default(uuid())
fantasy_name  String
cnpj          String     @unique()
social_reason String     @unique()
email         String
current_plan  String
logo_url      String?
users         User[]
trainings     Training[]
created_at    DateTime   @default(now())
updated_at    DateTime   @default(now())

@@index([email])
}
```

- At building models schemas always type the property as Enum when more appropriate. Example:

```
enum Plan {
  diamond
  platinum
  gold
}

model Company {
id            String     @id @default(uuid())
fantasy_name  String
cnpj          String     @unique()
social_reason String     @unique()
email         String
current_plan  Plan
logo_url      String?
users         User[]
trainings     Training[]
created_at    DateTime   @default(now())
updated_at    DateTime   @default(now())

@@index([email])
}
```

### 30/10/2024

- At uploading files to clouds, keep in mind that it is a best practice uploading files to a folder according the entity to updates and deletions do not affects other users files.

### 31/10/2024

- Avoid using fragments when performing map method over iterable objects, because it is not passing a key for a fragment.
- Always render all screens of your application paying attention to the console for catch invalidate code and avoid bugs as earlier as possible.

### 16/11/2024

- At passing functions to attributes that expects for events, always pass the function intermediated by another one. Example. Do:

```typescript
import { Check } from "lucide-react";

import React from "react";
import { formatUSD } from "../../../../lib/format";

export interface IProduct {
  id: string;
  title: string;
  price: number;
}

interface ProductCardProps {
  isSelected?: boolean;
  product: IProduct;
  onSelect: (product: IProduct) => void;
}

const ProductCard: React.FC<ProductCardProps> = ({
  isSelected,
  product,
  onSelect,
}) => {
  const handleClick = () => onSelect(product);

  return (
    <div
      className={`w-full flex border-2 ${
        isSelected ? "border-secondary" : "border-gray-100"
      } rounded-md  items-center py-1 px-3 cursor-pointer`}
      onClick={handleClick}
    >
      <div className="flex flex-col mt-1 m-2 grow">
        <span className="font-bold mt-3  text-[.7rem] md:text-[.8rem]">
          {product.title}
        </span>
        <p className="text-[.6rem] md:text-[.75rem] text-gray-600 max-w-[70%]">
          {formatUSD(product.price)}
        </p>
      </div>
      {isSelected && (
        <div className="w-5 h-5 flex items-center justify-center rounded-[1rem] z-10 bg-secondary p-1">
          <Check color="white" strokeWidth={4} />
        </div>
      )}
    </div>
  );
};

export default ProductCard;
```

instead:

```typescript
import { Check } from "lucide-react";

import React from "react";
import { formatUSD } from "../../../../lib/format";

export interface IProduct {
  id: string;
  title: string;
  price: number;
}

interface ProductCardProps {
  isSelected?: boolean;
  product: IProduct;
  onSelect: (product: IProduct) => void;
}

const ProductCard: React.FC<ProductCardProps> = ({
  isSelected,
  product,
  onSelect,
}) => {
  return (
    <div
      className={`w-full flex border-2 ${
        isSelected ? "border-secondary" : "border-gray-100"
      } rounded-md  items-center py-1 px-3 cursor-pointer`}
      onClick={() => onSelect()}
    >
      <div className="flex flex-col mt-1 m-2 grow">
        <span className="font-bold mt-3  text-[.7rem] md:text-[.8rem]">
          {product.title}
        </span>
        <p className="text-[.6rem] md:text-[.75rem] text-gray-600 max-w-[70%]">
          {formatUSD(product.price)}
        </p>
      </div>
      {isSelected && (
        <div className="w-5 h-5 flex items-center justify-center rounded-[1rem] z-10 bg-secondary p-1">
          <Check color="white" strokeWidth={4} />
        </div>
      )}
    </div>
  );
};

export default ProductCard;
```

### 19/11/2024

If you need to skip rerender in a child component caused by it parent component, use React.memo passing the logic for next renders as second param. In this example the child component will only rerender if prevStep.completed !== nextStep.completed.

```typescript
const CollapsibleStep = React.memo<CollapsibleStepProps>(
  ({ steps }) => {
    return (
      <div>
        {steps.map((step) => (
          <AccordionItem
            value={step.id}
            key={step.id}
            className="w-ful mb-4 bg-white border-2 border-gray-200 rounded-md px-2"
          >
            <AccordionTrigger
              disabled={step.disabled}
              className="disabled:opacity-[.5]"
            >
              <div className="flex items-center px-3 pt-3">
                {step.completed ? (
                  <CircleCheck className="bg-success text-white rounded-[1rem] mt-[-.75rem] mr-2" />
                ) : (
                  <CircleDot className="bg-primary text-white rounded-[1rem] mt-[-.75rem] mr-2" />
                )}
                <h2 className="text-[.8rem] md:text-[1rem] font-bold mb-3">
                  {step.name}
                </h2>
              </div>
            </AccordionTrigger>
            <AccordionContent>{step.component}</AccordionContent>
          </AccordionItem>
        ))}
      </div>
    );
  },
  (prevProps, nextProps) => {
    const hasCompletedStateChanged = nextProps.steps.some((nextStep, index) => {
      const prevStep = prevProps.steps[index];
      return prevStep.completed !== nextStep.completed;
    });

    return !hasCompletedStateChanged;
  }
);
```

### 20/11/2024

Use the techinique of mapping over objects when the data structure to map is known and small. Example. In this example TabSelector component was built to render few childrens based on the current active tab assign be the object key:

```typescript
import { useState } from "react";

interface TabSelectorProps {
  tabs: string[];
  defaultActiveTab: string;
  children: { [key: string]: React.ReactNode };
}

const TabSelector: React.FC<TabSelectorProps> = ({
  tabs,
  defaultActiveTab,
  children,
}) => {
  const [activeTab, setActiveTab] = useState(defaultActiveTab);

  return (
    <div className="w-full flex flex-col items-center mt-[2rem]">
      <div className="flex w-full max-w-[60rem] justify-center">
        {tabs.map((tab, i) => (
          <div
            key={i}
            onClick={() => setActiveTab(tab)}
            className={`w-full flex items-center justify-center p-4 text-gray-800 hover:text-white cursor-pointer bg-header hover:bg-neutral hover:shadow-md 
              ${i === 0 ? "rounded-tl-md rounded-bl-md" : ""} 
              ${i === tabs.length - 1 ? "rounded-tr-md rounded-br-md" : ""}`}
          >
            <span className="text-xl">{tab}</span>
          </div>
        ))}
        {children[activeTab]}
      </div>
    </div>
  );
};

export default TabSelector;
```

usage:

```typescript
import { useRef } from 'react';
import Cart from '../../../components/ui/Cart';
import TabSelector from '../../../components/ui/TabSelector';
import VerticalMenu from '../../../components/ui/VerticalMenu';
import { useCestaCompras } from '../../../hooks/useCestaCompras';

const Balanca: React.FC = () => {
  const tableRef = useRef<HTMLTableElement>(null);

  const {
    itemsCesta,
    totalItens,
    totalValor,
    onIncrementItem,
    onDecrementItem,
    onRemoveAllItems,
    onViewItem,
    onRemoveItem
  } = useCestaCompras();

  //TODO-PABLO: Verificar se tabs deve vir de config
  const tabs = {
    Padaria: <p>Padaria</p>,Ø
    Hortifruit: <p>Hortifruit</p>,
    Açougue: <p>Açougue</p>,
    Rotisseria: <p>Padaria</p>
  };

  const tabKeys = Object.keys(tabs);

  return (
    <div className='flex h-screen bg-screen'>
      <VerticalMenu />
      <div className='w-full flex flex-col items-center grow'>
        <div className='w-full flex flex-col items-center mt-[6rem] mb-8  '>
          <span className='ml-4 text-3xl font-bold text-gray-600'>
            Selecione os produtos por categoria
          </span>
          <TabSelector tabs={tabKeys} defaultActiveTab={tabKeys[0]} children={tabs} />
        </div>
      </div>
      <Cart
        itemsCesta={itemsCesta}
        onDecrementItem={onDecrementItem}
        onIncrementItem={onIncrementItem}
        onRemoveAllItems={onRemoveAllItems}
        onRemoveItem={onRemoveItem}
        onViewItem={onViewItem}
        totalItens={totalItens}
        totalValor={totalValor}
        tableRef={tableRef}
      />
    </div>
  );
};

export default Balanca;
```
### 22/11/2024

If you're facing late state updating issues, try removing unnecessary dependecies, and pay attention if you are using the same param to avoid unnecessary dependencies. Example:

```typescript
  const wrongImplelemntation = useCallback(
    (product: InfoProduto) => {
      setSelectedProduct(product);
        onSelectItem(selectedProduct!);
    },
    [onSelectItem, selectedProduct]
  );

  const rightImplementation = useCallback(
    (product: InfoProduto) => {
      setSelectedProduct(product); 
      onSelectItem(product); 
    },
    [onSelectItem]
  );
```

### 03/12/2024

At using react-modal for handling modals on react components, always define the root element reference to avoid errors reference on console. Example:

```typescript
import Modal from "react-modal";
import AppRouter from "./routes";
import "./styles/globals.css";

Modal.setAppElement("#root");

function App() {
  return (
      <div className="h-screen w-full bg-gray-100">
        <AppRouter />
      </div>
  );
}

export default App;
```

At working with Docker Compose where a service depends another service, do not use Wait For It configuration, use healthcheck declaration. Example:

```yml
version: '3.8'

services:
  postgres:
    container_name: dti-digital-db
    image: postgres
    ports:
      - 5432:5432
    environment:
      POSTGRES_USER: admin
      POSTGRES_PASSWORD: admin
      POSTGRES_DB: dti-digital-db
      PGDATA: /data/postgres
    volumes:
      - ./data/pg:/data/postgres
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U admin -d dti-digital-db"]
      interval: 10s
      timeout: 5s
      retries: 5

  dti-digital-server-app:
    container_name: dti-digital-server-app
    image: node:20-alpine
    working_dir: /usr/src/app
    command: ["sh", "-c", "npx prisma generate && npm run start:dev"]
    volumes:
      - ./:/usr/src/app
    ports:
      - 3335:3335
    depends_on:
      postgres:
        condition: service_healthy
    environment:
      DATABASE_URL: postgresql://admin:admin@dti-digital-db:5432/dti-digital-db?schema=public
```