# Python introduction course

## Installing and running Python on VS Code

1. Pick a Python version and download it for Mac at [python.org](https://www.python.org/downloads/).
2. Install the downloaded Python version.
3. Install the Python extension for VS Code.
4. Create a new `.py` file and write your Python program.
5. Run your program through `CTRL + F5` shortcut.


## Data types

- Strings: Are text strings.
- Numbers: Are numbers types, a number can be a real number or a floating number.
- Booleans: Are binary values for true and false.
- Lists: Are mutable and based on order arrays used to store any type of data.
- Tuples: Are immutable and based on order arrays used to store any type of data.
- Dictionaries: Are a list of peers containing keys and values.

## General tips

- Formatting methods does not must be used directly in the operation, example:
```python
real_number = 3
floating_number = 3.14
int_numbers_multiplication = real_number * floating_number
print(f"The multiplication between {real_number} and {floating_number} is {int(int_numbers_multiplication)}")
```
- On Python a variable is immutable, if you wanna to change it, you must assign another variable with the new data.
- Always parse a to list if you want to slice or manage it using list methods. Example:
```python
people_dict = {"name": "Pablo", "age" : 29, "developer" : True}
people_dict_values = list(people_dict.values())
print("people_dict values: ", people_dict_values)
```
- When using conditionals composed by if + else or if + elif + else, only a single condition is returned. It's completely different of using isolated if blocks.
- At using inputs for collect user response, always convert the typed user response to correctly be computed by your program based on the inputed data type. Example:
```python
# the method input allow to get user inputs through terminal, in this case, the use age inputted value is stored on age variable
age = int(input("How old are you?"))

# the program is basically checking for the inputted age and return a message for user
can_take_drive_license = "You can take your drive license" if age >= 18 else "You can't take your drive license"
print("Message: ", can_take_drive_license)
```
- At creating Python programs, use a `main.py` to refer to the main file. Do not use `index.py`.
- Use `while True`to persist a loop and a `break` condition to stop it at working with loops. Example:
```python
while True:
    print("Welcome to List tasks manager!")
    print("\nChoose the option you need to do:")
    print("1. Add a task")
    print("2. List tasks")
    print("3. Update a task")
    print("4. Mark a task as completed")
    print("5. Delete all completed tasks")
    print("6. Leave")

    userChoice = input("Type your choice: ")

    if userChoice == "6":
        break

    print("Program finished")
```
- Even your function does not returns nothing, it's a good practice providing a return declaration at the end of the function.
