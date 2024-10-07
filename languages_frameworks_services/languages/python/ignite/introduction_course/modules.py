from math import sqrt

number_input = int(input("Type a number"))
sqrt_number = sqrt(number_input)
print(f"The square root of {sqrt_number} is {sqrt_number}")

print("\nUsing my own modules")

from my_module import doubleNumber, greetUser

message = greetUser("Pablo")
double_number = doubleNumber(10)

print(message)
print(f"The double of 10 is {double_number}")