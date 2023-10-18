# Typing route params

To type route params and have the necessary data in the screen you need to read it you must:

1 - Exchange the type of the route is receiving the param from undefined to the object will need to receive, example:

```typescript
type AppRoutes = {
  home: undefined;
  exercise: {
    exerciseId: string;
  };
  profile: undefined;
  history: undefined;
}
```

2 - Create a type to represent the receiving param and assign route.params with this, example:

```typescript
import { useRoute } from '@react-navigation/native';

type RouteParamsProps = {
  exerciseId: string;
}

  const route = useRoute();
  const { exerciseId } = route.params as RouteParamsProps;
```

3 - Use the data you're receiving according the needs.