while True:
    print("\nWelcome to List tasks manager!")
    print("\nChoose the option you need to do:")
    print("\n1. Add a task")
    print("2. List tasks")
    print("3. Update a task")
    print("4. Mark a task as completed")
    print("5. Delete all completed tasks")
    print("6. Leave")

    userChoice = input("\nType your choice: ")

    if userChoice == "6":
        break

    print("Program finished")