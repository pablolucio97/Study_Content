# React most used Patterns

## Concepts

## 1. Component Composition

**Purpose**: Builds complex UIs by combining multiple small, reusable components.
**Usage**: Components are composed together by nesting, rather than inheritance, making them flexible and reusable.

**Example: Layout with Header, Sidebar, and Content.**

In this example, we have a Layout component that composes Header, Sidebar, and Content components. The Layout component takes each section as children, making it flexible and reusable.

```typescript
// Header.js
const Header = () => <header>Header Section</header>;

// Sidebar.js
const Sidebar = () => <aside>Sidebar Section</aside>;

// Content.js
const Content = ({ children }) => <main>{children}</main>;

// Layout.js
const Layout = ({ header, sidebar, content }) => (
  <div>
    {header}
    <div style={{ display: "flex" }}>
      {sidebar}
      {content}
    </div>
  </div>
);

// App.js
const App = () => (
  <Layout
    header={<Header />}
    sidebar={<Sidebar />}
    content={<Content>Page Content Here</Content>}
  />
);

export default App;
```

**Example 2: Button with Custom Icon and Text**
Here, a Button component receives Icon and Text components as children, allowing flexible customization of its contents.
In this example, we have a Layout component that composes Header, Sidebar, and Content components. The Layout component takes each section as children, making it flexible and reusable.

```typescript
// Icon.js
const Icon = ({ name }) => <span className={`icon-${name}`} />;

// Text.js
const Text = ({ children }) => <span>{children}</span>;

// Button.js
const Button = ({ children, onClick }) => (
  <button onClick={onClick} style={{ display: "flex", alignItems: "center" }}>
    {children}
  </button>
);

// App.js
const App = () => (
  <Button onClick={() => alert("Button clicked!")}>
    <Icon name="star" />
    <Text>Click Me</Text>
  </Button>
);

export default App;
```

---

## 2. Container/Presenter Pattern

**Purpose**: Separates the logic and data-fetching components (Container) from the UI-rendering components (Presenter).
**Usage**: The Container component handles data and state, while the Presenter focuses only on displaying UI. This pattern improves separation of concerns.

**Example: User Profile Display**
In this example, the UserContainer component fetches user data and passes it to the UserProfile component, which is responsible only for displaying the user information.

```typescript
import React from "react";

const UserProfile = ({ name, age, email }) => (
  <div>
    <h2>User Profile</h2>
    <p>Name: {name}</p>
    <p>Age: {age}</p>
    <p>Email: {email}</p>
  </div>
);

export default UserProfile;
```

```typescript
import React, { useEffect, useState } from "react";
import UserProfile from "./UserProfile";

const UserContainer = () => {
  const [user, setUser] = useState(null);

  useEffect(() => {
    // Simulate fetching user data from an API
    const fetchUser = async () => {
      const userData = {
        name: "John Doe",
        age: 30,
        email: "john.doe@example.com",
      };
      setUser(userData);
    };

    fetchUser();
  }, []);

  if (!user) {
    return <p>Loading user profile...</p>;
  }

  return <UserProfile name={user.name} age={user.age} email={user.email} />;
};

export default UserContainer;
```

---

## 3. Higher-Order Components (HOC)

**Purpose**: A function that takes a component and returns an enhanced version of that component with additional props or behavior.
**Usage**: Useful for sharing logic between components, such as adding authentication checks or handling loading states.

**Example: withLoading HOC**
This HOC wraps a component and provides it with a loading functionality. It displays a loading message until the data is available.

```typescript
import React, { useState, useEffect } from "react";

function withLoading(WrappedComponent) {
  return function WithLoadingComponent(props) {
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
      // Simulate data fetching
      const timer = setTimeout(() => setIsLoading(false), 2000);
      return () => clearTimeout(timer);
    }, []);

    if (isLoading) {
      return <p>Loading...</p>;
    }

    // Pass down all original props
    return <WrappedComponent {...props} />;
  };
}

export default withLoading;
```

```typescript
import React from "react";
import withLoading from "./withLoading";

const UserProfile = ({ name, age }) => (
  <div>
    <h2>User Profile</h2>
    <p>Name: {name}</p>
    <p>Age: {age}</p>
  </div>
);

export default withLoading(UserProfile);
```

---

## 4. Render Props Pattern

**Purpose**: A technique for sharing code by passing a function as a prop, where the function dictates what gets rendered.
**Usage**: Allows for reusable logic without creating new components, such as tracking mouse position or handling input changes.

**Example 1: Mouse Position Tracker**
In this example, we create a MouseTracker component that uses a render prop to provide the current mouse coordinates to any child component.

```javascript
import React, { useState } from "react";

const MouseTracker = ({ render }) => {
  const [position, setPosition] = useState({ x: 0, y: 0 });

  const handleMouseMove = (event) => {
    setPosition({
      x: event.clientX,
      y: event.clientY,
    });
  };

  return (
    <div style={{ height: "100vh" }} onMouseMove={handleMouseMove}>
      {render(position)}
    </div>
  );
};

export default MouseTracker;
```

```javascript
import React from "react";
import MouseTracker from "./MouseTracker";

const App = () => (
  <MouseTracker
    render={({ x, y }) => (
      <h1>
        The mouse position is ({x}, {y})
      </h1>
    )}
  />
);

export default App;
```

**Example 2: Data Fetcher**
In this example, we create a DataFetcher component that accepts a url and a render function. This component fetches data from the URL and provides it to the render function.

```javascript
import React, { useState, useEffect } from "react";

const DataFetcher = ({ url, render }) => {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        setData(data);
        setLoading(false);
      });
  }, [url]);

  return render({ data, loading });
};

export default DataFetcher;
```

```javascript
import React from "react";
import DataFetcher from "./DataFetcher";

const App = () => (
  <DataFetcher
    url="https://jsonplaceholder.typicode.com/posts/1"
    render={({ data, loading }) =>
      loading ? <p>Loading...</p> : <h1>{data.title}</h1>
    }
  />
);

export default App;
```

---

## 5. Controlled vs. Uncontrolled Components

**Purpose**: Defines how the value of an input element is managed.

- **Controlled Component**: The input's value is managed by React state, providing more control and predictability. Example of a Controlled Component:

```javascript
import React, { useState } from "react";

const ControlledInput = () => {
  const [inputValue, setInputValue] = useState("");

  const handleChange = (event) => {
    setInputValue(event.target.value);
  };

  return (
    <div>
      <label>
        Controlled Input:
        <input type="text" value={inputValue} onChange={handleChange} />
      </label>
      <p>Current Value: {inputValue}</p>
    </div>
  );
};
export default ControlledInput;
```

- **Uncontrolled Component**: The input's value is managed by the DOM imperatively, allowing simpler forms where full React control isn’t needed. Generally used at using validation form libraries like react-hook-form. Example of an Uncontrolled Component:

```javascript
import React, { useRef } from "react";

const UncontrolledInput = () => {
  const inputRef = useRef(null);

  const handleSubmit = () => {
    alert(`Current Value: ${inputRef.current.value}`);
  };

  return (
    <div>
      <label>
        Uncontrolled Input:
        <input type="text" ref={inputRef} />
      </label>
      <button onClick={handleSubmit}>Show Value</button>
    </div>
  );
};

export default UncontrolledInput;
```

---

## 7. Provider Pattern

**Purpose**: Uses a provider (usually with React Context) to allow components to access shared data without passing props through each level.
**Usage**: Commonly used with global state or configuration, especially with state management libraries.

**Example of Provider Pattern: Theme Context**
Let's create a simple example where a ThemeProvider provides theme data to its descendant components.

Step 1: Create the Context
In this step, we define the ThemeContext using React.createContext() and create a ThemeProvider to supply the theme data.

```javascript
import React, { createContext, useState } from "react";

// 1. Create the ThemeContext
export const ThemeContext = createContext();

// 2. Create the Provider Component
export const ThemeProvider = ({ children }) => {
  const [theme, setTheme] = useState("light");

  const toggleTheme = () => {
    setTheme((prevTheme) => (prevTheme === "light" ? "dark" : "light"));
  };

  return (
    <ThemeContext.Provider value={{ theme, toggleTheme }}>
      {children}
    </ThemeContext.Provider>
  );
};
```

Step 2: Wrap all application with the Provider
In App.js or the root component, wrap the entire component tree (or part of it) with ThemeProvider.

```javascript
import React from "react";
import { ThemeProvider } from "./ThemeContext";
import ThemedComponent from "./ThemedComponent";

const App = () => (
  <ThemeProvider>
    <ThemedComponent />
  </ThemeProvider>
);

export default App;
```

Step 3: Consume the Context
Now, let’s create a ThemedComponent that uses the ThemeContext to access and display the theme data.

```javascript
import React, { useContext } from "react";
import { ThemeContext } from "./ThemeContext";

const ThemedComponent = () => {
  const { theme, toggleTheme } = useContext(ThemeContext);

  return (
    <div
      style={{
        background: theme === "light" ? "#fff" : "#333",
        color: theme === "light" ? "#000" : "#fff",
      }}
    >
      <p>Current Theme: {theme}</p>
      <button onClick={toggleTheme}>Toggle Theme</button>
    </div>
  );
};

export default ThemedComponent;
```

---

## 8. Factory Pattern

**Purpose**: Creates objects or components dynamically, allowing variation in component creation.
**Usage**: Useful when you need to generate similar components with slight differences on demand.

**Example: React Component with slight variations**
In React, the Factory Pattern can be used to create components dynamically based on certain props or configurations. This is useful when you need to create multiple similar components with slight variations.

```typescript
// Define different button types
const PrimaryButton = ({ label }) => (
  <button style={{ backgroundColor: "blue", color: "white" }}>{label}</button>
);
const SecondaryButton = ({ label }) => (
  <button style={{ backgroundColor: "grey", color: "black" }}>{label}</button>
);
const DangerButton = ({ label }) => (
  <button style={{ backgroundColor: "red", color: "white" }}>{label}</button>
);

// Button factory function
function buttonFactory(type, label) {
  if (type === "primary") {
    return <PrimaryButton label={label} />;
  } else if (type === "secondary") {
    return <SecondaryButton label={label} />;
  } else if (type === "danger") {
    return <DangerButton label={label} />;
  } else {
    throw new Error("Unknown button type");
  }
}

// Usage in a React Component
const App = () => (
  <div>
    {buttonFactory("primary", "Save")}
    {buttonFactory("secondary", "Cancel")}
    {buttonFactory("danger", "Delete")}
  </div>
);

export default App;
```

---

## 9. Module Pattern

**Purpose**: Organizes related code in a single object or function, enhancing modularity and reusability.
**Usage**: Helps organize code into modules, which can be imported/exported as needed, commonly used with ES6 module syntax, util functions like formatting, conversion and so on.

Example: A function to calc geometric shapes that can be imported by application when needed.

```javascript
// Private variables and functions
const PI = 3.14159;

function square(x) {
  return x * x;
}

// Public API
export function circleArea(radius) {
  return PI * square(radius);
}

export function rectangleArea(length, width) {
  return length * width;
}
```

---

## 10. Observer Pattern

**Purpose**: Allows components to subscribe to updates from a central source (e.g., a store) and react to data changes where the "subject" object notify the "observers objects" that something has changed.
**Usage**: Often used in state management (e.g., Redux, Zustand, and similar global state management libraries) where components re-render when state changes.

**Example 1: Hook dependency:**

```typescript
import React, { useState, useEffect } from "react";

const Counter = () => {
  const [count, setCount] = useState(0);

  useEffect(() => {
    console.log(`The count has changed to: ${count}`);
    // Here, `count` is an observed dependency
  }, [count]); // `useEffect` observes `count`

  return (
    <div>
      <p>Count: {count}</p>
      <button onClick={() => setCount(count + 1)}>Increment</button>
    </div>
  );
};
```

**Example 2: Theme provider:**
In this example the provided value of the current state of theme acts as the subject object whereas all application acts wrapped by the provider acts as the observer.

---

## 11. Compound Components

**Purpose**: Allows multiple components to work together as a single unit, often sharing internal state through a context.
**Usage**: Commonly used in complex UI elements, like a tab component where individual tabs work together.

**Example: Tabs with Compound Components**
Step 1: Create the Tabs Context and Provider
The Tabs component will act as the provider, supplying context to its child components.

```javascript
import React, { useState, createContext, useContext } from "react";

const TabsContext = createContext();

const Tabs = ({ children }) => {
  const [activeTab, setActiveTab] = useState(0);

  return (
    <TabsContext.Provider value={{ activeTab, setActiveTab }}>
      <div className="tabs">{children}</div>
    </TabsContext.Provider>
  );
};

export default Tabs;
```

Step 2: Create the TabList and Tab Components
The TabList is a container for individual Tab components, which users can click to switch tabs.

```javascript
const TabList = ({ children }) => {
  return <div className="tab-list">{children}</div>;
};

const Tab = ({ index, children }) => {
  const { activeTab, setActiveTab } = useContext(TabsContext);

  return (
    <button
      className={`tab ${activeTab === index ? "active" : ""}`}
      onClick={() => setActiveTab(index)}
    >
      {children}
    </button>
  );
};

export { TabList, Tab };
```

Step 3: Create the TabPanel Component
The TabPanel displays the content associated with each tab.

```javascript
const TabPanel = ({ index, children }) => {
  const { activeTab } = useContext(TabsContext);

  return activeTab === index ? (
    <div className="tab-panel">{children}</div>
  ) : null;
};

export { TabPanel };
```

Step 4: Putting It All Together
The compound components can now be used in any order within the Tabs component, creating a flexible, reusable tabbed interface.

```javascript
import React from "react";
import Tabs, { TabList, Tab, TabPanel } from "./Tabs";

const App = () => (
  <Tabs>
    <TabList>
      <Tab index={0}>Tab 1</Tab>
      <Tab index={1}>Tab 2</Tab>
      <Tab index={2}>Tab 3</Tab>
    </TabList>
    <TabPanel index={0}>Content for Tab 1</TabPanel>
    <TabPanel index={1}>Content for Tab 2</TabPanel>
    <TabPanel index={2}>Content for Tab 3</TabPanel>
  </Tabs>
);

export default App;
```

---

## 12. Error Boundaries

**Purpose**: Catches errors in the component tree and provides a fallback UI without crashing the whole application.
**Usage**: Should be implemented always at handling possible API response errors inside the catch block.

Example 1 - Bounding the error using catch block:

```javascript
import React, { useState, useEffect } from "react";

const DataFetcher = () => {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        setLoading(true);
        setError(null); // Reset any previous errors
        const response = await fetch("https://api.example.com/data");

        if (!response.ok) {
          throw new Error(`Error: ${response.status} ${response.statusText}`);
        }

        const result = await response.json();
        setData(result);
      } catch (err) {
        setError(err.message); // Set error message to display to user
      } finally {
        setLoading(false);
      }
    };

    fetchData();
  }, []);

  if (loading) return <p>Loading...</p>;

  if (error) return <p>Oops! Something went wrong: {error}</p>;

  return (
    <div>
      <h1>Data from API:</h1>
      <pre>{JSON.stringify(data, null, 2)}</pre>
    </div>
  );
};

export default DataFetcher;
```

Example 2: Bounding the error using a class:

```javascript
import React, { Component } from "react";

class ErrorBoundary extends Component {
  constructor(props) {
    super(props);
    this.state = { hasError: false };
  }

  static getDerivedStateFromError(error) {
    // Update state to display fallback UI on the next render
    return { hasError: true };
  }

  componentDidCatch(error, info) {
    // Log error details to the console or an error tracking service
    console.error("Error caught by ErrorBoundary:", error, info);
  }

  render() {
    if (this.state.hasError) {
      // Display fallback UI
      return this.props.fallback || <h2>Something went wrong.</h2>;
    }

    // Render child components if no error
    return this.props.children;
  }
}

export default ErrorBoundary;
```

```javascript
import React, { useState } from "react";
import ErrorBoundary from "./ErrorBoundary";

const BuggyComponent = () => {
  const [count, setCount] = useState(0);

  if (count === 5) {
    // Intentionally throw an error when count reaches 5
    throw new Error("Count reached 5! Crashing component...");
  }

  return (
    <div>
      <p>Count: {count}</p>
      <button onClick={() => setCount(count + 1)}>Increment</button>
    </div>
  );
};

const App = () => {
  return (
    <div>
      <h1>Using Error Boundaries with Functional Components</h1>
      <ErrorBoundary
        fallback={<p>Something went wrong. Please try again later.</p>}
      >
        <BuggyComponent />
      </ErrorBoundary>
    </div>
  );
};

export default App;
```

## 13. Lazy Loading

**Purpose**: Loads components or modules on-demand to improve performance by reducing the initial bundle size.
**Usage**: Often implemented with `React.lazy` and `Suspense` to load components as needed.

Example 1: Loading heavy component:

```javascript
import React, { Suspense } from "react";

// Lazy load the component
const HeavyComponent = React.lazy(() => import("./HeavyComponent"));

const App = () => {
  return (
    <div>
      <h1>Lazy Loading Example</h1>
      <Suspense fallback={<div>Loading...</div>}>
        <HeavyComponent />
      </Suspense>
    </div>
  );
};

export default App;
```

Example 2: Loading a modal that will be only rendered later:

```javascript
// Lazy-load the modal component
const LazyModal = React.lazy(() => import("./LazyModal"));

const App = () => {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const openModal = () => setIsModalOpen(true);
  const closeModal = () => setIsModalOpen(false);

  return (
    <div>
      <h1>Lazy Loading Modal Example</h1>
      <button onClick={openModal}>Open Modal</button>

      {isModalOpen && (
        <Suspense fallback={<div>Loading modal...</div>}>
          <LazyModal onClose={closeModal} />
        </Suspense>
      )}
    </div>
  );
};

export default App;
```

## 14. Memoization

**Purpose**: Optimizes component re-renders by caching results of expensive operations or computations.
**Usage**: Implemented with `useCallback`, `React.memo` and `useMemo` to reduce unnecessary updates in performance-critical parts of the app.

**Example 1 - React.memo:**
In this example, we use React.memo to memoize a functional component, preventing it from re-rendering unnecessarily when the parent component re-renders.

```javascript
import React, { useState } from 'react';

const ChildComponent = React.memo(({ value }) => {
  console.log('Rendering ChildComponent');
  return <div>Value: {value}</div>;
});

const App = () => {
  const [count, setCount] = useState(0);
  const [value, setValue] = useState(10);

  return (
    <div>
      <h1>Memoization with React.memo</h1>
      <button onClick={() => setCount(count + 1)}>Increment Parent Count ({count})</button>
      <button onClick={() => setValue(value + 1)}>Increment Child Value ({value})</button>
      <ChildComponent value={value} />
    </div>
  );
};

export default App;
```

**Example 2 - useMemo:**
In this example, we use useMemo to cache the result of an expensive calculation. This way, the calculation only runs when necessary, not on every render.

```javascript
import React, { useState, useMemo } from 'react';

// Expensive calculation function
const expensiveCalculation = (num) => {
  console.log('Running expensive calculation...');
  for (let i = 0; i < 100000; i++) {} // Simulating heavy computation
  return num * 2;
};

const App = () => {
  const [count, setCount] = useState(0);
  const [number, setNumber] = useState(5);

  const computedValue = useMemo(() => expensiveCalculation(number), [number]);

  return (
    <div>
      <h1>Memoization with useMemo</h1>
      <p>Computed Value: {computedValue}</p>
      <button onClick={() => setCount(count + 1)}>Increment Count ({count})</button>
      <button onClick={() => setNumber(number + 1)}>Increment Number ({number})</button>
    </div>
  );
};
```

**Example 3 - UseCallback:**
In this example we'll perform the api fetch only if itemsPerPage hook's dependency changes.

```javascript
import React, { useState, useCallback } from 'react';

const App = () => {
  const [itemsPerPage, setItemsPerPage] = useState(10);

  const options = [
    {
        value: 10,
        label: 10
    },
    {
        value: 20,
        label: 20,
    }
  ]
  // Memoize the function to only call again if itemsPerPage changes
  const increment = useCallback(async () => {
    fetch("/api/products/list")
  }, [itemsPerPage]);

  return (
    <div>
      <h1>Memoization with useCallback</h1>
      <SectInput options={options} type='select' onChange={e => setItemsPerPage(e.value)}/>
    </div>
  );
};

export default App;
```

## 15. Flux/Redux Pattern

**Purpose**: Manages state in a predictable, unidirectional flow using actions and reducers.
**Usage**: Widely used for complex state management, where actions trigger state changes, and components respond to those changes.

**Example: counterReducer.**
In this example, we’ll create a simple counter application that uses useReducer for state management and Context to provide global access to the state and dispatch function.

Step 1: Create the Reducer and Context.
First, create the reducer function to define the possible actions (similar to a Redux reducer). Then, create a context to hold the global state and dispatch function.

```javascript
import React, { createContext, useReducer } from 'react';

// Define initial state
const initialState = { count: 0 };

// Define the reducer function
const counterReducer = (state, action) => {
  switch (action.type) {
    case 'INCREMENT':
      return { count: state.count + 1 };
    case 'DECREMENT':
      return { count: state.count - 1 };
    default:
      return state;
  }
};

// Create the Context
const CounterContext = createContext();

// Create a provider component
const CounterProvider = ({ children }) => {
  const [state, dispatch] = useReducer(counterReducer, initialState);

  return (
    <CounterContext.Provider value={{ state, dispatch }}>
      {children}
    </CounterContext.Provider>
  );
};

export { CounterContext, CounterProvider };
```
Step 2: Use the Provider in the Application.

```javascript
import React from 'react';
import { CounterProvider } from './CounterContext';
import Counter from './Counter';

const App = () => {
  return (
    <CounterProvider>
      <div>
        <h1>React Context and useReducer Counter Example</h1>
        <Counter />
      </div>
    </CounterProvider>
  );
};

export default App;
```

Step 3: Create a Component that Uses the Context

```javascript
import React, { useContext } from 'react';
import { CounterContext } from './CounterContext';

const Counter = () => {
  const { state, dispatch } = useContext(CounterContext);

  return (
    <div>
      <h1>Counter: {state.count}</h1>
      <button onClick={() => dispatch({ type: 'INCREMENT' })}>Increment</button>
      <button onClick={() => dispatch({ type: 'DECREMENT' })}>Decrement</button>
    </div>
  );
};

export default Counter;
```

## 16. Accessibility features

**Purpose**: Turn the application more accessible to all users .
**Usage**: Widely used for complex state management, where actions trigger state changes, and components respond to those changes.

**Example: Form Validation with aria-live**
In this example, we use aria-live to provide screen reader-friendly feedback when a form validation error occurs. When the error state updates, screen readers will announce the error message.

```javascript
import React, { useState } from 'react';

const AccessibleForm = () => {
  const [name, setName] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (name.trim() === '') {
      setError('Name is required.');
    } else {
      setError('');
      alert('Form submitted!');
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <label htmlFor="name">Name:</label>
      <input
        type="text"
        id="name"
        value={name}
        onChange={(e) => setName(e.target.value)}
        aria-describedby="error-message"
      />
      <button type="submit">Submit</button>

      {/* Error message with aria-live for screen reader announcement */}
      <div id="error-message" role="alert" aria-live="assertive" style={{ color: 'red' }}>
        {error}
      </div>
    </form>
  );
};

export default AccessibleForm;
```

## 17. Functional components

**Purpose**: Turn the application code more easier to write and read, and has access to hooks and component life cycle easier.
**Usage**: Widely used for creating any component instead of using classes components.

Example - Button component:

```typescript
import { ButtonHTMLAttributes } from "react";

interface ButtonProps extends ButtonHTMLAttributes<HTMLButtonElement> {
  title: string;
}

export function Button({ title, ...rest }: ButtonProps) {
  return (
    <button
      {...rest}
    >
      {title}
    </button>
  );
}
```

## General tips

- For turning the application more accessible, use semantic HTML and put arial-label and aria attributes in your HTML elements, inputs, buttons, images and text.
- For considering a component as a compound component, generally it must share a small context between couple others components.

```

```
