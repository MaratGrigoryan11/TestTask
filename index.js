function getData(){
    fetch('posts',{method: "GET",})
        .then(response => response.json()).then(data => createResult(data))
        .catch(function(res){
            console.log(res)
        })
}

function createResult(obj){
    var result = Object.entries(obj)
    console.log(result)

    for (const arrElement of result) {

        document.getElementById('root').innerHTML += `<li>key: ${arrElement[0]} value: ${arrElement[1]}<input id="${arrElement[0]}" name="delete" type="submit" onclick="deletePost(this.id)" value="Delete"></li>`

    }
}
getData()

function setData(){
    let key = document.getElementById('key').value
    let value = document.getElementById('value').value
    let data = {
        key: key,
        value: value,
    }
    console.log(JSON.stringify(data))
    fetch("posts",
        {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify(data)
        })
        .then(function(res){ console.log(res) })
        .catch(function(res){ console.log(res) })
    location.reload()
}

function deletePost(key){
    fetch("posts/"+key,
        {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "DELETE",
        })
        .then(function(res){ console.log(res) })
        .catch(function(res){ console.log(res) })
    location.reload()
}