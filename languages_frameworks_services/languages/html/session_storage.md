

## 📦 Session Storage in JavaScript

### ✅ What is Session Storage?

Session Storage is part of the Web Storage API. It allows you to store key-value pairs in a user's browser — specifically tied to a *single tab session*. The data:

- Is kept **only while the tab is open**
- **Is not shared between tabs**
- Gets **cleared when the tab or browser is closed**

---

### 🔐 Use Cases

- Save temporary form data
- Preserve user progress within a tab
- Store UI preferences (e.g. sidebar collapsed state)
- Cache non-sensitive data for the current session

---

### 🛠️ How to Use

```
sessionStorage.setItem('username', 'pablo');
const user = sessionStorage.getItem('username');
sessionStorage.removeItem('username');
sessionStorage.clear();
```

---

### 🔍 Key Facts

- Session Storage only accepts **strings** as values.
- To store **objects**, use `JSON.stringify()` and `JSON.parse()`:

```
const user = { name: "Pablo", age: 30 };
sessionStorage.setItem("user", JSON.stringify(user));

const storedUser = JSON.parse(sessionStorage.getItem("user"));
```

---

## ✅ When `sessionStorage` Is Useful

1. **Form progress per tab**  
   Imagine a user filling out a long form in two tabs. With `sessionStorage`, each tab stores its own input data separately — no conflict.

2. **Prevent shared session bugs**  
   In apps like banking or checkout flows, isolated tabs avoid cross-tab interference or race conditions.

3. **Multi-tab workflows**  
   Developers may want each tab to maintain its own temporary state, like filters or step-by-step wizards, without overwriting others.

---

## ❌ When It’s Not Suitable

If you want **shared state across tabs**, consider using:

- **`localStorage`**: Shared across all tabs from the same origin.
- **`IndexedDB`**: Structured, persistent storage across tabs.
- **BroadcastChannel API**: Allows real-time communication between tabs.

---

## 🔄 Comparison Table

| Storage         | Shared Across Tabs? | Lifespan        | Use Case                                |
|-----------------|---------------------|------------------|------------------------------------------|
| `sessionStorage`| ❌ No                | Until tab closes | Per-tab session state                    |
| `localStorage`  | ✅ Yes               | Persistent       | Shared user settings, auth token, etc.   |
| `IndexedDB`     | ✅ Yes               | Persistent       | Structured data like cache or files      |

---

#html #javascript #web #reference

**Related:** [[web_essentials_concepts]] | [[javascript_course]]
