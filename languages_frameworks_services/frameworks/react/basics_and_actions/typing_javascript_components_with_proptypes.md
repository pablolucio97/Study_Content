# Typing Props for React JS Components

---

## 1. Install `prop-types`

Use this command to add support for typing props in JavaScript-based React projects:

```bash
yarn add prop-types -D
```

---

## 2. Define and Use PropTypes in a Component

Here’s an example using `prop-types` to validate props:

```jsx
import P from 'prop-types';
import './styles.css';

export const PostCard = ({ title, cover, body, id, isActive }) => (
  <>
    <div className="post">
      <img src={cover} alt={title} />
      <div className="post-content">
        <h2>
          {title} {id}
        </h2>
        <p>{body}</p>
      </div>
    </div>
  </>
);

// Define expected prop types and requirements
PostCard.propTypes = {
  title: P.string.isRequired,
  cover: P.string.isRequired,
  body: P.string.isRequired,
  id: P.number.isRequired,
  isActive: P.bool, // Optional prop
};
```

---

## ✅ Notes

- All props marked with `.isRequired` must be passed to the component.
- Optional props (like `isActive`) can be omitted.
- PropTypes help catch bugs during development by validating prop usage.
