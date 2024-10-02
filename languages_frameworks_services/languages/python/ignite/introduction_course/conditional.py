age = 19

# when using conditionals composed by if + else or if + elif + else, only a single condition is returned

if age >= 18:
    print("You're overage.")
elif age >= 12:
    print("You're a teenager.")
else:
    print("You're underage")
    
# this form  to compare is widely used:
can_take_drive_license = "You can take your drive license" if age >= 18 else "You can't take your drive license"
print("Message: ", can_take_drive_license)
