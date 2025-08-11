# Framer Motion Course

Framer Motion is a React component designed to allow you to configure amazing animations for your React projects.  
This library includes **motion** (the core of the library that allows animating any element from `motion.element` or your own `ReactElement`), **gestures**, **scroll** and more.

---

## Framer Motion Animations Examples

```tsx
<motion.div
  animate={{ x: [0, 100, 0] }}
  transition={{ duration: 0.4, delay: 1, yoyo: 3 }}
  style={{ background: 'red' }}
>
  <h1>ok</h1>
</motion.div>
```

---

```tsx
<motion.div
  whileHover={{ scale: 1.1, type: 'spring', stiffness: 300 }}
  transition={{ type: 'spring', stiffness: 1000 }}
>
  <PrimaryButton
    title="Title"
    onClick={() => {}}
  />
</motion.div>
```

---

## Using Variants

```tsx
const containerAnimationVariants = {
  hidden: {
    opacity: 0,
    x: '100vw'
  },
  visible: {
    opacity: 1,
    x: 0
  },
}

<motion.div
  variants={containerAnimationVariants}
  initial="hidden"
  animate="visible"
  transition={{ duration: 0.3, type: 'spring', stiffness: 120 }}
  style={{ background: 'red' }}
>
  <h1>ok</h1>
</motion.div>
```

---

## Using the `useScroll` Hook

```tsx
import { Container } from './styles';
import { motion, useScroll } from 'framer-motion';

export function ReadProgressBar() {
  const { scrollYProgress } = useScroll();

  return (
    <Container>
      <motion.div style={{ scaleX: scrollYProgress }} />
    </Container>
  );
}
```

---

## General Tips

- Using an array to contain your style props works as **keyframes**.  
- Set the prop `stiffness` if you're using the **spring** as animation type.