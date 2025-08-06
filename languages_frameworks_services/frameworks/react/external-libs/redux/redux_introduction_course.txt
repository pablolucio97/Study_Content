# Redux Introduction Course

Redux must be used when your application needs to manage complex states to avoid performance issues when using ContextAPI.

---

## Flow Architecture

Redux is based on **Flow architecture**, allowing you to manage global state in a predictable way.

### Concepts

- **Actions**: Triggered by functions and carry data to reducers. Must have a unique `type` string.
- **Reducer**: Isolated piece of global state logic. Listens to actions and updates the state accordingly.
- **Middlewares (e.g., Redux Saga)**: Intercept actions for verification or async work before dispatching.

---

## 1. Install Redux

```bash
yarn add react-redux redux redux-devtools-extension immer
```

---

## 2. Create Actions

```ts
import { IProduct } from './types'

export function addProductToCardRequest(product: IProduct) {
  return {
    type: 'ADD_PRODUCT_TO_CARD_REQUEST',
    payload: { product }
  }
}
```

---

## 3. Create Reducer

```ts
import { Reducer } from "redux";
import produce from 'immer'
import { ICartState } from "./types";

const INITIAL_STATE: ICartState = {
  items: [],
  failedStockCheck: []
}

const cart: Reducer<ICartState> = (state = INITIAL_STATE, action) => {
  return produce(state, draft => {
    switch (action.type) {
      case 'ADD_PRODUCT_TO_CART_SUCCESS':
        const { product } = action.payload
        const index = draft.items.findIndex(i => i.product.id === product.id)
        index >= 0 ? draft.items[index].quantity++ : draft.items.push({ product, quantity: 1 })
        break
      case 'ADD_PRODUCT_TO_CART_FAILURE':
        draft.failedStockCheck.push(action.payload.productId)
        break
    }
  });
}

export default cart;
```

---

## 4. Combine Reducers

```ts
import { combineReducers } from 'redux';
import cart from './cart/reducer';

export default combineReducers({ cart });
```

---

## 5. Create Store

```ts
import { createStore } from 'redux'
import { composeWithDevTools } from 'redux-devtools-extension'
import rootReducer from './modules/rootReducer'

export const store = createStore(rootReducer, composeWithDevTools())
```

---

## 6. Use Redux in Component

```tsx
import { useSelector } from 'react-redux'
import { IState } from '../../store'
import { ICartItem } from '../../store/modules/cart/types'

const cart = useSelector<IState, ICartItem[]>(state => state.cart.items)
```

---

# Applying Redux Saga Middleware

## 1. Install

```bash
yarn add redux-saga
```

---

## 2. Create Saga

```ts
import { all, takeLatest, select, call, put } from 'redux-saga/effects'

function* checkProductsStock({ payload }) {
  const { product } = payload
  const currentQuantity = yield select(state => state.cart.items.find(item => item.product.id === product.id)?.quantity ?? 0)
  const stock = yield call(api.get, `/stock/${product.id}`)
  stock.data.quantity > currentQuantity
    ? yield put(addProductToCartSuccess(product))
    : yield put(addProductToCartFailure(product.id))
}

export default all([
  takeLatest('ADD_PRODUCT_TO_CART_REQUEST', checkProductsStock)
])
```

---

## 3. Create Root Saga

```ts
import { all } from 'redux-saga/effects'
import cart from './cart/sagas'

export default function* rootSaga() {
  return yield all([cart])
}
```

---

## 4. Setup Store with Saga

```ts
import { createStore, applyMiddleware } from 'redux'
import createSagaMiddleware from 'redux-saga'
import rootReducer from './modules/rootReducer'
import rootSaga from './modules/rootSaga'

const sagaMiddleware = createSagaMiddleware()
const store = createStore(rootReducer, composeWithDevTools(applyMiddleware(sagaMiddleware)))
sagaMiddleware.run(rootSaga)

export default store
```

---

# Creating and Consuming Reducers (Alternative Method)

## 1. Create Actions

```ts
export const ADD_NEW_CYCLE = 'ADD_NEW_CYCLE'
export const FINISH_CURRENT_CYCLE = 'FINISH_CURRENT_CYCLE'

export function addNewCycleAction(newCycle) {
  return { type: ADD_NEW_CYCLE, payload: { newCycle } }
}

export function markCurrentCycleAsFinishedAction() {
  return { type: FINISH_CURRENT_CYCLE }
}
```

---

## 2. Create Reducer

```ts
import { produce } from "immer"

export function cyclesReducer(state, action) {
  switch (action.type) {
    case "ADD_NEW_CYCLE":
      return produce(state, draft => {
        draft.cycles.push(action.payload.newCycle)
        draft.activeCycleId = action.payload.newCycle.id
      })
    case "FINISH_CURRENT_CYCLE":
      const index = state.cycles.findIndex(c => c.id === state.activeCycleId)
      if (index < 0) return state
      return produce(state, draft => {
        draft.activeCycleId = null
        draft.cycles[index].finishedDate = new Date()
      })
    default:
      return state
  }
}
```

---

## 3. Use Reducer in Component

```ts
const [state, dispatch] = useReducer(cyclesReducer, { cycles: [], activeCycleId: null }, () => {
  const stored = localStorage.getItem("@app:cyclesState")
  return stored ? JSON.parse(stored) : { cycles: [], activeCycleId: null }
})
```

---

## 4. Trigger Reducer Actions

```ts
dispatch(addNewCycleAction(newCycle))
dispatch(markCurrentCycleAsFinishedAction())
```

---

# General Tips

- Always export actions as `{ type, payload }`.
- Use `immer` to safely mutate state.
- Use only `*_SUCCESS` action in reducer to prevent race conditions.
- Use `yield` in sagas as if they were `await`.
- Keep action types in a `TypeScript enum`.
- Ensure types are respected in payloads and reducers.
