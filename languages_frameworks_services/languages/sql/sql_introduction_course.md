# SQL Introduction Course

## SQL Commands

### Basic Querying

- `SELECT`: Retrieves data from one or more database tables.  
- `FROM`: Specifies the table or tables from which the data is retrieved.  
- `WHERE`: Filters the result set based on specified conditions.  
- `DISTINCT`: Retrieves unique values from a column or columns.  
- `AS`: Renames a column or table using an alias.  
- `ORDER BY`: Sorts the result set based on specified columns.  
- `GROUP BY`: Groups rows based on one or more columns.  
- `HAVING`: Filters the grouped result set based on specified conditions.  
- `LIMIT`: Specifies the maximum number of rows to retrieve.  
- `OFFSET`: Specifies the number of rows to skip in the result set.  

### Joining Tables

- `JOIN`: Combines rows from two or more tables based on a related column.  
- `INNER JOIN`: Retrieves rows that have matching values in both tables being joined.  
- `LEFT JOIN`: Retrieves all rows from the left table and matching rows from the right table.  
- `RIGHT JOIN`: Retrieves all rows from the right table and matching rows from the left table.  
- `FULL JOIN`: Retrieves all rows from both tables, regardless of the match.  
- `ON`: Specifies the join condition in the JOIN clause.  

### Data Manipulation

- `INSERT`: Inserts new data into a table.  
- `UPDATE`: Modifies existing data in a table.  
- `DELETE`: Removes data from a table.  
- `TRUNCATE`: Removes all rows from a table, while maintaining the structure.  

### Subqueries and Conditions

- `IN`: Checks if a value matches any value in a list or subquery.  
- `NOT`: Negates a condition in a WHERE or HAVING clause.  
- `EXISTS`: Checks if a subquery returns any rows.  
- `BETWEEN`: Filters the result set based on a range of values.  
- `LIKE`: Filters the result set based on a pattern match.  
- `NOT LIKE`: Filters the result set based on a pattern mismatch.  
- `IS NULL`: Checks if a value is null.  
- `IS NOT NULL`: Checks if a value is not null.  
- `ALL`: Compares a value with all values in a subquery.  
- `ANY`: Compares a value with any value in a subquery.  

### Conditional Logic

- `CASE`: Performs conditional logic in a query.  
  - `WHEN`: Specifies a condition in a CASE statement.  
  - `THEN`: Specifies a result in a CASE statement.  
  - `ELSE`: Specifies a default result in a CASE statement.  

### Aggregation Functions

- `AVG`: Calculates the average value of a column.  
- `MAX`: Retrieves the maximum value from a column.  
- `MIN`: Retrieves the minimum value from a column.  
- `SUM`: Calculates the sum of values in a column.  
- `COUNT`: Counts the number of rows or non-null values in a column.  

### String Functions

- `CONCAT`: Concatenates two or more strings.  

## SQL Basic Operations – Examples

Using a sample table `users`:

```sql
-- Table: users
-- Columns: id (INT), name (VARCHAR), email (VARCHAR), age (INT)
```

---

### ✅ SELECT – Retrieve data

```sql
SELECT * FROM users;
-- Retrieves all rows and columns from the users table
```

---

### ➕ INSERT – Add new data

```sql
INSERT INTO users (name, email, age)
VALUES ('Alice Smith', 'alice@example.com', 30);
-- Inserts a new user into the users table
```

---

### ✏️ UPDATE – Modify existing data

```sql
UPDATE users
SET age = 31
WHERE name = 'Alice Smith';
-- Updates the age of the user named Alice Smith to 31
```

---

### ❌ DELETE – Remove specific data

```sql
DELETE FROM users
WHERE email = 'alice@example.com';
-- Deletes the user with the specified email
```

---

### 🧹 TRUNCATE – Remove all rows (fast delete)

```sql
TRUNCATE TABLE users;
-- Deletes all records from the users table (structure remains intact)
```

## 🔄 SQL JOINs – Complex Query Examples with Explanations

We’ll use two sample tables:

```sql
-- Table: users
-- id | name         | email
-- 1  | Alice Smith  | alice@example.com
-- 2  | Bob Jones    | bob@example.com

-- Table: orders
-- id | user_id | product      | amount
-- 1  | 1       | Book         | 25.00
-- 2  | 1       | Pen          | 3.00
-- 3  | 2       | Notebook     | 12.00
-- 4  | NULL    | Anonymous    | 5.00
```

---

### 🤝 INNER JOIN – Only matching rows in both tables

```sql
SELECT users.name, orders.product, orders.amount
FROM users
INNER JOIN orders ON users.id = orders.user_id;
```

🔍 **Explanation**: Returns only the orders that are linked to a user. Orders without a matching `user_id` in `users` are excluded.

---

### 📥 LEFT JOIN – All from left, matched from right

```sql
SELECT users.name, orders.product, orders.amount
FROM users
LEFT JOIN orders ON users.id = orders.user_id;
```

🔍 **Explanation**: Returns all users, and their orders if available. If a user has no orders, their order fields will be `NULL`.

---

### 📤 RIGHT JOIN – All from right, matched from left

```sql
SELECT users.name, orders.product, orders.amount
FROM users
RIGHT JOIN orders ON users.id = orders.user_id;
```

🔍 **Explanation**: Returns all orders, and user info if linked. Orders without a user (e.g. guest purchases) still show up.

---

### 🌐 FULL JOIN – All from both, matched where possible

```sql
SELECT users.name, orders.product, orders.amount
FROM users
FULL OUTER JOIN orders ON users.id = orders.user_id;
```

🔍 **Explanation**: Returns all users and all orders. Where there's no match, the missing side is filled with `NULL`.

---

### 🧮 JOIN with Aggregation

```sql
SELECT users.name, COUNT(orders.id) AS total_orders
FROM users
LEFT JOIN orders ON users.id = orders.user_id
GROUP BY users.name;
```

🔍 **Explanation**: Shows the total number of orders each user made. Users with no orders show `0`.

---

### 🛒 JOIN with WHERE + ORDER BY

```sql
SELECT users.name, orders.product, orders.amount
FROM users
JOIN orders ON users.id = orders.user_id
WHERE orders.amount > 10
ORDER BY orders.amount DESC;
```

🔍 **Explanation**: Retrieves only orders above $10, joined with user data, and sorted by the order amount descending.