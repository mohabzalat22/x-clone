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