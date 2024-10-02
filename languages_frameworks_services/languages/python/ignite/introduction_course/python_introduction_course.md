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