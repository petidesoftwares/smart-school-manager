let width = 240; // We will scale the photo width to this
let height = 240; // This will be computed based on the input stream

let streaming = false;

let video = null;
let canvas = null;
let photo = null;
let startbutton = null;
$(document).ready(function (){
    // if(screen.width ===425 || screen.width <425){
    //     let mobile = document.getElementById('mobile-header');
    //     let desktop =document.getElementById('desktop-header');
    //     mobile.style.display = "block";
    //     desktop.style.display = "none";
    // }

})

function showSideBarMenu(){
    document.getElementById('side-bar').style.display = "block";
}

function closeSideBarMenu(){
    document.getElementById('side-bar').style.display = "none";
}

function hideSideBarMenu(){
    if (screen.width === 425 || screen.width < 425){
        document.getElementById('side-bar').style.display = "none";
    }
}

function showAdmissionForm(){
    $.ajax({
        type: "post",
        url:"../admin-uis/admit-student.php",
        success: function (response){
            document.getElementById('main-content').innerHTML = "";
            document.getElementById("main-content").innerHTML = response;

            getTitle('parent-title');
            getStates('student-state');
        },
        error: function (error){
            alert(error);
        }
    })

    hideSideBarMenu();
}

function showViewStudentPane(){
    $.ajax({
        type: "post",
        url:"../admin-uis/view-students.php",
        success: function (response){
            document.getElementById('main-content').innerHTML = "";
            document.getElementById("main-content").innerHTML = response;
        },
        error: function (error){
            alert(error);
        }
    })

    hideSideBarMenu();
}

function showParentForm(){
    document.getElementById('parent-data-pane').style.display = "block";
    document.getElementById('add-parent-btn').style.display = "none";
}

function selectViewCategory(e){
    const category = e.value
       if(category === "section"){
           document.getElementById('section-category').style.display = "inline-block";
           document.getElementById('class-category').style.display = "none";
           return;
       }
       if(category === "class"){
           document.getElementById('section-category').style.display = "none";
           document.getElementById('class-category').style.display = "inline-block";
           return;
       }
       if(category === "all"){
           document.getElementById('section-category').style.display = "none";
           document.getElementById('class-category').style.display = "none";
           getAllStudents();
       }
}

function showPassportFileUpload(){
    document.getElementById('pupil-passport-file-pane').style.display = 'block';
    document.getElementById('passport-from-file-btn').style.backgroundColor = "darkslateblue";
    document.getElementById('run').style.backgroundColor = "darkslategrey";
    document.getElementById('camera-pane').style.display = 'none';
    document.getElementById('capture-btn-pane').style.display = 'none';
}

/**************Reusable Utilities *****************/

function getTitle(id){
    $.ajax({
        type:'post',
        url: '../../backend/App/gettitles.php',
        success: function (response){
            let obj = JSON.parse(response);
            for(let i =0; i< obj.length; i++){
                let option = document.createElement('option');
                option.value = obj[i].title;
                option.text = obj[i].title;
                document.getElementById(id).appendChild(option);
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function getStates(id){
    $.ajax({
        type:'post',
        url: '../../backend/App/getstates.php',
        success: function (response){
            let obj = JSON.parse(response);
            for(let i =0; i< obj.length; i++){
                let option = document.createElement('option');
                option.value = obj[i].id;
                option.text = obj[i].state;
                document.getElementById(id).appendChild(option);
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function getLGAs(id){
    const state_id = document.getElementById('student-state').value;
    $.ajax({
        type:'post',
        url: '../../backend/App/getlgas.php',
        data: {state_id: parseInt(state_id)},
        success: function (response){
            document.getElementById(id).innerHTML = "";
            let obj = JSON.parse(response);
            let option1 = document.createElement('option');
            option1.text = "Choose LGA";
            document.getElementById(id).appendChild(option1);
            for(let i =0; i< obj.length; i++){
                let option = document.createElement('option');
                option.value = obj[i].lga;
                option.text = obj[i].lga;
                document.getElementById(id).appendChild(option);
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function validateTextField(fieldID, errorPaneID, fieldName){
    const value = document.getElementById(fieldID).value;
    if(value === "" || value === null){
     document.getElementById(errorPaneID).innerHTML = fieldName+" cannot be empty";
     return false;
    }
    document.getElementById(errorPaneID).innerHTML = "";
    return true;
}

function validateNumberField(fieldID, errorPaneID, fieldName){
    const value = document.getElementById(fieldID).value;
    if(value === null){
        document.getElementById(errorPaneID).innerHTML = fieldName+" cannot be empty";
        return false;
    }
    document.getElementById(errorPaneID).innerHTML = "";
    return true;
}

function validateEmail(fieldID, errorPaneID){
    const value = document.getElementById(fieldID).value;
    const emailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!value.match(emailReg)){
        document.getElementById(errorPaneID).innerHTML = "Enter a valid email address";
        return false;
    }
    document.getElementById(errorPaneID).innerHTML = "";
    return true;
}

function validatePhoneNumber(fieldID,errorPaneID){
    const mobileRegex = RegExp('^([0|+[0-9]{1,3})?([7-9][0-9]{9})$');
    const value = document.getElementById(fieldID).value;
    if(value.length < 1){
        document.getElementById(errorPaneID).innerHTML = "Phone number field cannot be empty";
        return false;
    }if(value.length<10){
        document.getElementById(errorPaneID).innerHTML = "Phone number must be between 10 to 14 digits";
        return false;
    }if(value.length>15){
        document.getElementById(errorPaneID).innerHTML = "Phone number must not exceed 14 digits";
        return false;
    }
    if(!mobileRegex.test(value)){
        document.getElementById(errorPaneID).innerHTML = "Please enter a valid phone number";
        return false
    }
    document.getElementById(errorPaneID).innerHTML = "";
    return true;
}

function validateRadioButton(inputName, errorPane, fieldName){
    const value = $('input[name="'+inputName+'"]:checked').val();
    if(value === "" || value === null || value === undefined){
        document.getElementById(errorPane).innerHTML = fieldName + " field is required";
        return false;
    }
    document.getElementById(errorPane).innerHTML = "";
    return true;
}

function validateDate(dateFielID, errorPane){
    const value = document.getElementById(dateFielID).value;
    const date = new Date();
    const inputDate = new Date(value);

    if(value === "" || value === null){
        document.getElementById(errorPane).innerHTML = "Date of birth cannot be empty";
        return false;
    }
    if(date.getDate()-inputDate.getDate() < 0 || date.getDate()-inputDate.getDate() === 0){
        document.getElementById(errorPane).innerHTML = "Date of birth cannot be later than or exactly today";
        return false;
    }
    document.getElementById(errorPane).innerHTML = "";
    return true;

}

/***************End reusable utilities *************/

function admitStudent(){
    validateRadioButton('student-gender','student-gender-error', 'Student gender');
    if(!validateTextField('student-firstname', 'student-firstname-error', 'First Name')){
        return;
    }
    if(!validateTextField('student-surname', 'student-surname-error', 'Surname')){
        return;
    }
    if(!validateRadioButton('student-gender','student-gender-error', 'Student gender')){
        return;
    }
    if(!validateTextField('student-class', 'student-class-error', 'Admission class')){
        return;
    }
    if(!validateDate('student-dob', 'student-dob-error')){
        return;
    }
    if(!validateTextField('student-section', 'student-section-error', "Pupil's section")){
        return;
    }
    if(!validateTextField('student-state', 'student-state-error', "Pupil's State of origin")){
        return;
    }
    if(!validateTextField('student-lga', 'student-state-error', "Pupil's LGA")){
        return;
    }
    if(!validateTextField('parent-title', 'parent-title-error', "Parent title")){
        return;
    }
    if(!validateTextField('parent-firstname', 'parent-firstname-error', "Parent firstname")){
        return;
    }
    if(!validateTextField('parent-surname', 'parent-surname-error', "Parent surname")){
        return;
    }
    if(!validateRadioButton('parent-gender','parent-gender-error', 'Parent gender')){
        return;
    }
    if(!validatePhoneNumber('parent-phone-number', 'parent-phone-number-error')){
        return;
    }
    if(!validateEmail('parent-email', 'parent-email-error')){
        return;
    }
    if(!validateTextField('occupation', 'occupation-error', "Occupation")){
        return;
    }

    const admissionData ={
        firstname:document.getElementById('student-firstname').value,
        surname: document.getElementById('student-surname').value,
        othername: document.getElementById('student-othername').value,
        student_gender: $('input[name ="student-gender"]:checked').val(),
        admitted_into: document.getElementById('student-class').value,
        date_of_birth: document.getElementById('student-dob').value,
        section: document.getElementById('student-section').value,
        state_of_origin: document.getElementById('student-state').value,
        lga: document.getElementById('student-lga').value,
        parent_title: document.getElementById('parent-title').value,
        parent_firstname: document.getElementById('parent-firstname').value,
        parent_surname: document.getElementById('parent-surname').value,
        parent_othername: document.getElementById('parent-othername').value,
        parent_gender: $('input[name="parent-gender"]:checked').val(),
        parent_phone: document.getElementById('parent-phone-number').value,
        parent_email:document.getElementById('parent-email').value,
        parent_occupation: document.getElementById('occupation').value
    }

    $.ajax({
        type:'post',
        url: '../../backend/App/admission.php',
        data: admissionData,
        success: function (response){
            alert(response);
        },
        error: function (error){
            alert(error);
        }
    })
}

function startup() {
    document.getElementById('pupil-passport-file-pane').style.display = 'none';
    document.getElementById('camera-pane').style.display = 'block';
    document.getElementById('run').style.backgroundColor = 'darkslateblue';
    document.getElementById('passport-from-file-btn').style.backgroundColor = "darkslategrey";
    document.getElementById('capture-btn-pane').style.display = 'block';

    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('capturebtn');

    navigator.mediaDevices.getUserMedia({
        video: true,
        audio: false
    }).then(function(stream) {
        window.localStream = stream;
            video.srcObject = stream;
            video.play();
        }).catch(function(err) {
            console.log("An error occurred: " + err);
        });

    video.addEventListener('canplay', function(ev) {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);

            if (isNaN(height)) {
                height = width / (4 / 3);
            }

            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);
}


function clearphoto() {
    let context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    let data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
}

function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);

        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
    } else {
        clearphoto();
    }
}

function previewPassport(obj){
    let formData = new FormData();
    formData.append("tempPassport", obj.files[0]);

    $.ajax({
        type:'post',
        url:'../../backend/image-controller/preview-passport.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response){
            // console.log(response);
            if(response.indexOf('ERROR')>=0){
                alert(response);
            }else{

                document.getElementById('photo').setAttribute('src', response);
                console.log(response);
            }
        },
        error: function (error){
            alert(error);
        }
    })
    // console.log(formData.get('tempPassport'));
}

function stopCapture(){
    localStream.getVideoTracks()[0].stop();
    video.src = "";
}

function savePassport(){
    let formData = new FormData();
    const image = document.getElementById('photo');
    formData.append('image', image.getAttribute('src'));

    $.ajax({
        url:"../../backend/image-controller/save-passport.php",
        type:"post",
        data: formData,
        contentType: false,
        processData: false,
        success:function (response){
            console.log(response);
            stopCapture();
        },
        error:function (error){
            alert(error);
        }
    })
}

function getAllStudents(){
    $.ajax({
        type:"post",
        url:'../../backend/App/get-all-students.php',
        success: function (response){
            let pupildata = JSON.parse(response);
            let s_n = 1;
            document.getElementById('view-table-body').innerHTML = "";
            for(let i =0; i<pupildata.length; i++){
                let row = document.createElement('tr');
                let cell1 = document.createElement('td');
                let cell2 = document.createElement('td');
                let cell3 = document.createElement('td');
                let cell4 = document.createElement('td');
                let cell5 = document.createElement('td');
                let cell6 = document.createElement('td');

                cell1.innerHTML = s_n;
                cell2.innerHTML = pupildata[i].firstname;
                cell3.innerHTML = pupildata[i].surname;
                cell4.innerHTML = 'Nil';
                cell5.innerHTML = '<img src="../../statics/images/icons/edit_black_24dp.svg">';
                cell6.innerHTML = '<img src="../../statics/images/icons/delete_black_24dp.svg">';

                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                row.appendChild(cell4);
                row.appendChild(cell5);
                row.appendChild(cell6);

                document.getElementById('view-table-body').appendChild(row);
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function getStudentsBySection(e){
    const section = {section:e.value};
    $.ajax({
        type:'post',
        url: '../../backend/App/get-pupil-by-section.php',
        data: section,
        success: function (response){
            let pupildata = JSON.parse(response);
            let s_n = 1;
            document.getElementById('view-table-body').innerHTML = "";
            for(let i =0; i<pupildata.length; i++) {
                let row = document.createElement('tr');
                let cell1 = document.createElement('td');
                let cell2 = document.createElement('td');
                let cell3 = document.createElement('td');
                let cell4 = document.createElement('td');
                let cell5 = document.createElement('td');
                let cell6 = document.createElement('td');

                cell1.innerHTML = s_n;
                cell2.innerHTML = pupildata[i].firstname;
                cell3.innerHTML = pupildata[i].surname;
                cell4.innerHTML = 'Nil';
                cell5.innerHTML = '<img src="../../statics/images/icons/edit_black_24dp.svg">';
                cell6.innerHTML = '<img src="../../statics/images/icons/delete_black_24dp.svg">';

                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                row.appendChild(cell4);
                row.appendChild(cell5);
                row.appendChild(cell6);

                document.getElementById('view-table-body').appendChild(row);
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function getStudentsByClass(e){
    alert("by class");
}



