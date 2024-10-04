# exceptions are events that can happen during the code execution and has the potential to finish your code if not treated correctly. Using excepetions correctly the error will be shown for user, but the program will not be stopped.

# Exceptions examples:
# TypeError:  Could happen when you expect by a number and user inputs a string
# ValueError:  Could happen when you expect by a number and user inputs a string that can not be converted to integer: ex: "a"

#In the example below we are checking for ValueError and global exceptions (Exception keyword). The result will be printed only if there is none error, and the "Program finished" will be printed in any case.

try:
    number_input = int(input("Type a number:"))
    result = 10 / number_input
except ValueError as valueError:
    print(f"We had a value error: ", valueError)
except Exception as globalException:
    print(f"Something get wrong:", globalException)
else:
    print(f"The result is: {result}")
finally:
    print("Program finished.")