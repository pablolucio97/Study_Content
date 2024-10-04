tasks = []

def addTask(tasksList, taskName="default_task"):
    task = {"name": taskName, "isComplete" : False}
    tasksList.append(task)
    print(f"Task '{taskName}' was added successfully!")
    return 


def listTasks(tasks):
    if int(len(tasks)) < 1:
        print("\nYour tasks list is empty.")
    else:
          print("\n Tasks list:")
          for index, task in enumerate(tasks, start=1):
            status = "[✓]" if task["isComplete"] else ""
            print(f"{index} [{status}] - {task["name"]}")
    return

def updateTaskName(tasks, taskIndex, newTaskName):
    fixedIndex = int(taskIndex) - 1
    if fixedIndex >= 0 and fixedIndex < len(tasks):
        tasks[fixedIndex]["name"] = newTaskName
        print(f"Task {taskIndex} updated to {newTaskName}")
    else:
        print("Index does not exists.")
    return

def markTaskAsCompleted(tasks, taskIndex):
    fixedIndex = int(taskIndex) -1
    if fixedIndex >= 0 and fixedIndex < len(tasks):
        tasks[fixedIndex]["isComplete"] = True
        print(f"Task {taskIndex} completed successfully!")
    else:
        print("Index does not exists.")
    return

def deleteCompletedTasks(tasks):
    for task in tasks:
        if task["isComplete"]:
            tasks.remove(task)
            print("Completed tasks were removed.")
    return

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

    elif userChoice == "2":
        listTasks(tasks)

    elif userChoice == "3":
        listTasks(tasks)
        taskIndexInput = input("Type the number of the task you want to update: ")
        newTaskNameInput = input("Type the new task name: ")
        updateTaskName(tasks, taskIndexInput, newTaskNameInput)

    elif userChoice == "4":
      listTasks(tasks)
      taskIndexInput = input("Type the number of the task you want to mark as completed: ")
      markTaskAsCompleted(tasks, taskIndexInput)

    elif userChoice == "5":
        deleteCompletedTasks(tasks)
        listTasks(tasks)
    
    elif userChoice == "6":
        break

print("Program finished")