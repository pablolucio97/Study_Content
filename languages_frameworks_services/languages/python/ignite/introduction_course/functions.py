
# function without a return example:
def greetUser(userName):
    print(f"Hello, {userName}!")

print("\n Calling greetUser function:")
greetUser("Pablo")


# function with a return example:
def numberCubic(number):
    return number ** 3

print("calling numberCubic function: ", numberCubic(4))


#function with multiple params example:
def calcNumbers(n1, n2, n3):
    result = n1 + n2 * n3
    print(f"The result of {n1} + {n2} * {n3} is {result}")

print("calling calcNumbers function: ", calcNumbers(2,3,4))