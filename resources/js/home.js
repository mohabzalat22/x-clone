let upload_button = document.getElementById('upload-file-button');
upload_button?.addEventListener('click',(e)=>{
    console.log('click');
    let upload_file = document.getElementById('upload-file');
    upload_file.click();
});

let backgroundImgButton = document.getElementById('background_img_button');
backgroundImgButton?.addEventListener('click', (e)=>{
    let upload_background = document.getElementById('backgroundimg');
    upload_background.click();
});    

let profileImgButton = document.getElementById('profile_img_button');
profileImgButton?.addEventListener('click', (e)=>{
    let upload_profile = document.getElementById('profileimg');
    upload_profile.click();
});    

// user-search
let userSearch = document.getElementById("user-search");
userSearch.addEventListener('input',(e)=>{
    let menu = document.getElementById("user-search-menu");
    menu.innerHTML='';
    if(userSearch.value == ''){
        menu.classList.add('d-none')
    }
    else{
        menu.classList.remove('d-none')
    }
    let response = fetch(`/api/v1/users?user=${userSearch.value}`,{
        method : "GET",
        headers:{
            Accept : "application/js"
        }
    }).then((resolve)=>{
        if(!resolve.ok){
            throw new Error(`Response status ${resolve.status}`);
        }
        else {
            return resolve.json();
        }
    });
    response.then((data)=>{
        if(data.length != 0){
            document.getElementById("user-search-menu").innerHTML='';
            data.forEach((dataElement)=>{
                let userSearchMenu = document.getElementById("user-search-menu");
                let userRecord = document.createElement('a');
                userRecord.href = "/profile/" + dataElement['id'];
                userRecord.classList.add('d-flex', 'px-4', 'py-1', 'light-hover', 'rounded-3' ,'text-decoration-none' ,'text-dark')
                //  image
                let userRecordImg = document.createElement('img');
                userRecordImg.style.width = "40px";
                userRecordImg.style.height = "40px";
                userRecordImg.classList.add('rounded-circle', 'd-block', 'bg-dark' , 'object-fit')
                if(dataElement['profile_picture']){
                    userRecordImg.src = '/storage/profileAssets/images/'+ dataElement['profile_picture'];
                }
                // data
                let userData = document.createElement('div');
                userData.classList.add('ps-2', 'd-flex', 'flex-column', 'justify-content-center');
                //
                let username = document.createElement('p');
                let email = document.createElement('p');
                //
                username.classList.add('fw-bold', 'm-0');
                username.textContent = dataElement['name'];
                //
                email.classList.add('small', 'text-muted', 'm-0');
                email.textContent = dataElement['email'];
                userData.appendChild(username);
                userData.appendChild(email);
                //
                userRecord.appendChild(userRecordImg);
                userRecord.appendChild(userData);
                // final
                userSearchMenu.appendChild(userRecord);
            });
        }
        else{
            document.getElementById("user-search-menu").innerHTML='';
        }
    });
    
});

