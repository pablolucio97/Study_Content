# WORKING WITH TESTS IN REACT

## TYPES OF TESTS AND CONCEPTS

### Unit Tests
Unit tests test only a single function, class, or component separated from the application. If this function or component is integrated or depends on actions bonded with features of the application, it is called a Mock.

### Automated Tests

### Test Driven Development (TDD)
TDD is the practice of writing tests before creating your application.

### Integration Tests
Integration tests test the integration of a component with another component or functionality.

### E2E (End-to-End) Tests
E2E tests evaluate each point of the flow of an action. Use E2E tests for functionalities that require a high level of responsibility. Example: Purchase and authentication processes.

### Static Tests
Static tests check for syntax and types before executing the code and enforce consistent code style.

## DOING UNITY TESTS

1. Install the Jest and the React Testing Library running: ´yarn add jest jest-dom @testing-library/jest-dom @testing-library/dom 
@testing-library/react babel-jest identity-obj-proxy ts-jest -D´ 

2. In the root of your project, create a new file named jest.config.js with the
configs:

```javascript
module.exports={
    testPathIgnorePatterns: ["/node_modules", "/.next"],
    setupFilesAfterEnv: ["<rootDir>/src/tests/setupTest.ts"],
    transform: {
        "^.+\\.(js|jsx|ts|tsx)$" : "<rootDir>/node_modules/babel-jest"
    },
    moduleNameMapper: {
        "\\.(css|scss|saas)$" : "identity-obj-proxy"
    },
    testEnvironment: "jsdom",
    collectCoverage: true,
    collectCoverageFrom: [
        "src/**/*.tsx",
        "!src/**/*.spec.tsx",
        "!src/**/_app.tsx",
        "!src/**/_document.tsx"
    ],
    coverageReporters: [
        "lcov",
        "json"
    ]
}
```

3. Create a new folder named tests and inside this a new setupTest.ts file 
with the statements:

```
import '@testing-library/jest-dom'
import '@testing-library/jest-dom/extend-expect';
```

4. In the root of your project, create a new file named babel.config.js with the
configs:

```
module.exports={
    presets: ['next/babel']
}
```

5. Create a folder named test with your test file_name.spec.tsx and write your test. 

Example 01: In this example has three tests to check functionalities rely to Button component.


```javascript
import {fireEvent, render, screen} from '@testing-library/react'
import {Button} from './index'
describe('<Button/>', () => {
    it('should render the button with the text', () => {
        render(<Button text='load more'/>)
        const button = screen.getByRole('button', {name: /load more/i})
        expect(button).toBeInTheDocument();
        //passed
    })

    it('should call a function when button receiveis a click', () => {
        const fn = jest.fn()
        render(<Button text='load more' onClick={fn}/>)
        const button2 = screen.getByRole('button', {name: /load more/i})
        fireEvent.click(button2)
        fireEvent.click(button2)
        expect(fn).toHaveBeenCalledTimes(2);
        //passed
    })

    it('should be disabled when disabled is true', () => {
        render(<Button text='load more' disabled={true}/>)
        const button3 = screen.getByRole('button', {name: /load more/i})
        expect(button3).toBeDisabled()
        //passed
    })
})
```

Example 02: Tests if a component is rendered correctly and has a class:

```javascript
import { render, screen } from '@testing-library/react'
import ActiveLink from '.'

jest.mock('next/router', () => {
    return {
        useRouter() {
            return {
                asPath: '/'
            }
        }
    }
})

describe('ActiveLink component', () => {
    it('active link should renders correctly', () => {
        const { debug, getByText } = render(
            <ActiveLink
                activeClassName='active'
                href='/'
            >
                <p>OK!</p>
            </ActiveLink>
        )
        debug()
        expect(screen.getByText('OK!')).toBeInTheDocument()
    })
    
    it('active link is receiving the href attribute string', () => {
        render(
            <ActiveLink
                activeClassName='active'
                href='/'
            >
                <p>OK!</p>
            </ActiveLink>
        )
        expect(screen.getByText('OK!')).toHaveClass('active')
    })
    
})
```


Example 03. In this example w'll to test if the application is returning the SignInButton component correctly according to the useSession value. The mocked function will be used to return value of useSession mock in each situation, example:

```javascript
import {render, screen} from '@testing-library/react'
import {SignInButton} from './index'
import {useSession} from 'next-auth/client'
import {mocked} from 'ts-jest/utils'

jest.mock('next-auth/client')

describe('SignInButton', () => {
  it('should render the button to login if the user is not logged', () => {

    const useSessionMocked = mocked(useSession)

    useSessionMocked.mockReturnValueOnce([null, false])

    render(
        <SignInButton/>
    )
    expect(screen.getByText('SignIn with GitHub')).toBeInTheDocument()
  })

  it('should render the button to logout with the user named if user is logged', () => {
    const useSessionMocked = mocked(useSession)
    useSessionMocked.mockReturnValueOnce([
        {user: {name: 'John Doe', email: 'johndoe@eamil.com'}, expires: 'fake-expires'}
        , false])
      render(
          <SignInButton />
      )
      expect(screen.getByText('John Doe')).toBeInTheDocument()
  })

})
```


Example 4: Testing components that doesn't are in the DOM immediatally. These components will be rendered after a map.


```javascript
const childrensContent = ['el1', 'el2', 'el3']

describe('Badge', () => {
    it('should render correctly', () => {

        render(
            <CardSlider
                slidesToScroll={3}
                slidesToShow={3}
            >
                {childrensContent.map(children => (
                    <p key={children}>{children}</p>
                ))}
            </CardSlider>
            , {
                wrapper: StyledProvider
            })

        
            const component = screen.findByText('el1')
            waitFor(() => {expect(component).toBeInTheDocument()})

    })
})
```

Example 5: Components that interacts with Window object:

```javascript
 it('should call backToTop function onClick', () => {

    const { container } = render(
      <>
        <div id='top'></div>
        <TopScrollButton
          ariaLabel='Back to top'
          elementReferenceId='top'
          icon={<MdArrowUpward />}
        />
      </>
      , {
        wrapper: StyledProvider
      }
    )

    window.HTMLElement.prototype.scrollIntoView = function() {}

    const button = container.querySelector('[aria-label="Back to top"]')

    expect(fireEvent.click(button!)).toBeTruthy()

  })
  ```


6. Run `yarn test` to run your tests. If your package.json file don't has a test script, use "test": `jest --watch`.


## Testing functions

Example 1. A function to format strings:

```typescript

export const greetUser = (userName: string) => {
  return `Olá, ${userName}!`
}


import { greetUser } from "./greetUser";

describe("greetUser", () => {
  it("should return user greeting correctly", () => {
    const greeting = greetUser("Pablo");
    expect(greeting).toBe("Olá, Pablo!");
  });
});

```

Example 2. A function to sort arrays.:

```typescript
export const sortNames = (names: string[]) => {
  return names.sort()
}


import { sortNames } from "./sortNames";

describe("sortNames", () => {
  it("should sort names correctly", () => {
    const names = ["John, Paul", "Anne"];
    const sortedNames = sortNames(names);
    expect(sortedNames).toEqual(["Anne", "John, Paul"]);
  });
});
```

## Checking the coverage tests percentage

1. After configured coverage reportes under your jest.config.js file, use the flag `--coverage` in your test script command.

2. In the browser or in the console your can check the % of coverage of your whole application.

## Using mocks

 Checks if onPress was called with the second city object in the data array ({ id: '2', name: 'Campo grande', latitude: 789, longitude: 487 }). This confirms that the component correctly identifies which item was pressed and passes the correct data to the event handler:

 ```typescript
 import { render, screen, fireEvent } from "@testing-library/react-native"

import { SelectList } from '@components/SelectList'

describe("Component: SelectList", () =>{
  it('should be return city details selected', async() => {
    const data = [
      { id: '1', name: 'Campinas', latitude: 123, longitude: 456 },
      { id: '2', name: 'Campo grande', latitude: 789, longitude: 487 }
    ]

    const onPress = jest.fn();

    render(
      <SelectList 
        data={data}
        onChange={() =>{}}
        onPress={onPress}
      />
    )

    const selectedCity = screen.getByText(/campo/i)
    fireEvent.press(selectedCity)

    expect(onPress).toBeCalledTimes(1)
    expect(onPress).toBeCalledWith(data[1])
  })
})
 ```

 -----------


 Check and await for API response (the mock must be in a separated file):


 ```typescript
  import { CityAPIResponse } from '@services/getCityByNameService'
  export const mockCityAPIResponse: CityAPIResponse = {
    id: '1',
    name: 'São Paulo',
    sys: {
      country: 'BR'
    },
    coord: {
      lat: 123,
      lon: 456
    }
  }
 ```

 ```typescript

 const getCityByNameService = api.get("/cities/list").then(res => res.data)

 import { api } from './api'
 import { mockCityAPIResponse } from '@__tests__/mocks/mockCityAPIResponse'
  import { getCityByNameService } from './getCityByNameService'
  describe("API: getCityByNameService", () => {
    it('should return city details', async () => {
      jest.spyOn(api, "get").mockResolvedValue({ data: mockCityAPIResponse })
      const response = await getCityByNameService('São Paulo')
      expect(response.length).toBeGreaterThan(0)
    })
  })
```

## Testing Hooks

In this example w'll test a authentication hook performing an async signIn operation.

```typescript
//AuthContext.tsx
import { createContext, useContext, useState } from "react";

interface AuthContextProps {
  isAuthenticated: boolean;
  signIn: () => Promise<void>;
}

export const AuthContext = createContext({} as AuthContextProps);

export const AuthContextProvider = ({ children }) => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  const signIn = async () => {
    setIsAuthenticated(true);
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, signIn }}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  return useContext(AuthContext);
};

//AuthContext.spec.ts

import { renderHook, waitFor } from "@testing-library/react";
import { act } from "react-test-renderer";
import { AuthContextProvider, useAuth } from "./AuthContext";

describe("AuthContext", () => {
  it("should get isAuthenticated value after signIn", async () => {
    const { result } = renderHook(useAuth, { wrapper: AuthContextProvider });

    await act(async () => {
      await result.current.signIn();
    });

    // Wait for the state update to be reflected
    await waitFor(() => expect(result.current.isAuthenticated).toBeTruthy());
  });
});

```

## Using custom renders. 

Custom renders are useful in situations you need render two or more contexts at once. To use a custom render, first create it, export you custom render assigning it to render method from the library you're using and use it on your test. Example:

```typescript
//__tests__/utils/customRender.tsx
import { ReactElement, ReactNode } from "react";
import { CityProvider } from "@contexts/CityContext";
import { SafeAreaProvider } from "react-native-safe-area-context";
import { RenderOptions, render } from "@testing-library/react-native";
function Providers({ children }: { children: ReactNode }) {
  return (
    <SafeAreaProvider>
      <CityProvider>
        {children}
      </CityProvider>
    </SafeAreaProvider>
  )
}
const customRender = (
  ui: ReactElement,
  options?: Omit<RenderOptions, 'wrapper'>
) => render(ui, { wrapper: Providers, ...options })
export * from '@testing-library/react-native'
export { customRender as render, Providers }


//src/routes/routes.test.tsx
import { screen, waitFor } from "@testing-library/react-native"
import { Routes } from "@routes/index"
import { saveStorageCity } from "@libs/asyncStorage/cityStorage"
import { render } from "@__tests__/utils/customRender"

describe("Routes", () => {
  it('should be render Search screen when not city selected', async () => {
    render(
      <Routes />
    )

    const title = await waitFor(() => screen.findByText(/^escolha um local/i))

    expect(title).toBeTruthy()
  })
  it('should be render Dashboard screen when has city selected', async () => {
    const city = {
      id: '1',
      name: 'São Paulo',
      latitude: 123,
      longitude: 456
    }
    
    await saveStorageCity(city)
    const { debug } = render(<Routes />)
    debug()
  })
})

```

## Integration tests.

To understand integration tests, first you need to identity the flow you want to test. 

In this example will be test the integration of the searchInput component that is present on the Search screen with an array of options that feed a list of options. At changing the text of the searchInput component, it will trigger an API call that feed a select input with options returned by the API. Example:

```typescript
import { render, screen, fireEvent, waitFor } from "@__tests__/utils/customRender"
import { mockCityAPIResponse } from "@__tests__/mocks/api/mockCityAPIResponse"
import { Search } from "@screens/Search"
import { api } from "@services/api"
describe('Screen: Search', () => {
  it('should be show city option', async () => {
    jest.spyOn(api, "get").mockResolvedValue({ data: mockCityAPIResponse })
    
    render(<Search />)
    const searchInput = screen.getByTestId('search-input')
    fireEvent.changeText(searchInput, "São Paulo")
    const option = await waitFor(() => screen.findByText(/são paulo/i))
    expect(option).toBeTruthy()
  })
})
```

In this example will be tested if cityName is shown correctly after the result of the API was resolved correctly and the city was stored on storage.

```typescript
import { mockWeatherAPIResponse } from "@__tests__/mocks/api/mockWeatherAPIResponse"
import { render, screen, waitFor } from "@__tests__/utils/customRender"
import { api } from "@services/api"
import { Dashboard } from "@screens/Dashboard"
import { saveStorageCity } from "@libs/asyncStorage/cityStorage"
import { mockCityAPIResponse } from "@__tests__/mocks/api/mockCityAPIResponse"

it('should be show city weather', async () => {
  // Spy on the `get` method of the `api` service and mock its resolved value to return a predefined response.
  jest.spyOn(api, 'get').mockResolvedValue({ data: mockWeatherAPIResponse });

  // Define a city object with specific properties.
  const city = {
    id: '1',
    name: 'Rio do Sul, BR',
    latitude: 123,
    longitude: 456
  };

  // Save the city information in storage, simulating a situation where the city is already selected by the user.
  await saveStorageCity(city);

  // Render the Dashboard component to the DOM.
  render(<Dashboard />);

  // Wait for the component to display the city name and assert that it appears, confirming the component is showing the city's weather.
  const cityName = await waitFor(() => screen.findByText(/rio do sul/i));
  expect(cityName).toBeTruthy();
});
```

[Repository for testing references](https://github.com/rocketseat-education/ignite-rn-08-iweather)


# GENERAL TIPS FOR TESTING

- **Use fake databases** for testing CRUD operations and sending emails.
- Use **coverage** to measure how much of your component is covered by tests.
- Always write tests with **accessibility** in mind.
- Run tests while focusing on **expected outcomes**.
- Check **expect.assertions()** when working with asynchronous tests to ensure assertions are executed.
- Components that users do not interact with may not need tests.
- Use the **describe()** method to categorize tests for the current component.
- Use **jest.mock()** to simulate actions and extract props your component depends on from real application files.
- Use **mocked()** from `ts-jest` to return different mock values in various situations. This is useful for testing **conditional rendering**.
- Be careful with **data conversion** in tests; verify the data conversion and check for expected results.
- Use **toEqual(expect.objectContaining({}))** to match values strictly with the expected result.
- Use **data-testid** to assign IDs to components and retrieve them with **getByTestId()** in tests.
- If you cannot find an element, use **screen.logTestingPlaygroundURL()** to open the **Testing Playground** in the browser and explore ways to find components in tests.
- Keep tests alongside the component or page they test, naming the test file exactly like the component to avoid coverage conflicts.
- Use **waitFor** to test components that do not appear in the DOM immediately.
- Use **mockReturnValueOnce** to test specific situations for conditional rendering, such as checking if a user is authenticated.
- Focus on **integration tests** for a more comprehensive view of your application's functionality.
- When testing API returns, use **spyOn()** and expect the exact data returned by the API.
- Store all mocks in a **`__tests__/mocks`** folder.
- When mocking **native modules**, check if the library supports Jest and follow its integration guide.
- For rendering **SVG components** or similar, install the specific library and configure it in your **jest.config.json** file according to the documentation.
- Use **beforeAll()** or **afterAll()** for repeated code in isolated tests, and use **beforeEach** or **afterEach** for code needed in each test.
- Use **waitFor** for asynchronous tests, especially for elements that take time to render in the Jest test tree.
- At working with tests using Jest, be careful at using methods started with `query` or `get` because it return different kind of errors because `get` expects for the element existing on test tree, and `get` does not. It has different kind of behaviors.
![img](https://i.ibb.co/34xNzPy/Screenshot-2024-10-11-at-08-20-39.png)
