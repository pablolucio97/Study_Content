const users = [
    'Pablo',
    'Camila',
    'Camila',
    'Pablo',
    'Camila',
    'Camila',
    'Pablo',
    'Camila',
    'Camila',
    'Pablo',
    'Camila',
    'Camila',
    'Jennhy'
]

const countUsers = (avatars) => {
    const result = {}
    avatars.forEach(item => { result[item] = (result[item] || 0) + 1})
    return result
}

//console.log(countUsers(users))

const sortUsers = (countedAvatars) => {
    const result = []
    for (prop in countedAvatars){
        result.push([prop, countedAvatars[prop]])
    }
    const sorted = result.sort((a,b) => b[1] - a[1])
    console.log(sorted)
}

sortUsers(countUsers(users))
