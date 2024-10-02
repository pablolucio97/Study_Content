# the method input allow to get user inputs through terminal, in this case, age is the input
age = int(input("How old are you?"))

# the program is basically check for the inputted age and return a message for user
can_take_drive_license = "You can take your drive license" if age >= 18 else "You can't take your drive license"
print("Message: ", can_take_drive_license)
