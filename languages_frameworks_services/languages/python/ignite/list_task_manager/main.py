def addTask(tasksList, taskName="default_task"):
    task = {"name": taskName, "isComplete" : False}
    tasksList.append(task)
    print(f"Task '{taskName}' was added successfully!")
    return 

tasks = []

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

    if userChoice == "1":
        taskInput = input("Type the task name: ")
        addTask(tasks, taskInput)

    if userChoice == "6":
        break

    print("Program finished")