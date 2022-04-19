let width = 240; // We will scale the photo width to this
let height = 240; // This will be computed based on the input stream

let streaming = false;

let video = null;
let canvas = null;
let photo = null;
let startbutton = null;

let subjectCount = 1;
$(document).ready(function (){
    const menuItems = document.getElementsByClassName('"menu-item"');
    for(let i=0; i< menuItems.length; i++){
        menuItems[i].addEventListener('click', function (){
            alert(this.innerHTML);
            this.classList.toggle('active');
        })
    }
    hideSideBarMenu();
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

function showSubjectUploadPane(){
    $.ajax({
        type:"post",
        url: "../admin-uis/upload-subjects.php",
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

function createTeacherView(){
    $.ajax({
        type: "post",
        url:"../admin-uis/create-teacher.php",
        success: function (response){
            document.getElementById('main-content').innerHTML = "";
            document.getElementById("main-content").innerHTML = response;

            getTitle('teacher-title');
            document.getElementById('teaching-type-pane').style.display = 'none';
        },
        error: function (error){
            alert(error);
        }
    })
    hideSideBarMenu();
}

function showAssignSubjectView(){
    $.ajax({
        type: "post",
        url:"../admin-uis/assign-subject.php",
        success: function (response){
            document.getElementById('main-content').innerHTML = "";
            document.getElementById("main-content").innerHTML = response;
            getSubjectsToAssign();
        },
        error: function (error){
            alert(error);
        }
    })
    hideSideBarMenu();
}

function showTeachingType(){
    document.getElementById('teaching-type-pane').style.display = 'block';
}

function hideTeachingType(){
    document.getElementById('teaching-type-pane').style.display = 'none';
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

/*****************New updates 02/04/2022*************/
function showViewTeacherPane(){

    $.ajax({
        type: 'GET',
        url: '../../backend/App/get-all-teachers.php',
        success: function (serverResponse){
            const teachersDetails = JSON.parse(serverResponse);

            $.ajax({
                type: "post",
                url:"../admin-uis/view-teachers.php",
                success: function (response){
                    document.getElementById('main-content').innerHTML = "";
                    document.getElementById("main-content").innerHTML = response;

                    //Extract data from server and populated created table
                    let s_n = 1;
                    document.getElementById('view-teachers-table-body').innerHTML = "";
                    for(let i =0; i<teachersDetails.length; i++) {
                        let row = document.createElement('tr');
                        let cell1 = document.createElement('td');
                        let cell2 = document.createElement('td');
                        let cell3 = document.createElement('td');
                        let cell4 = document.createElement('td');
                        let cell5 = document.createElement('td');
                        let cell6 = document.createElement('td');
                        let cell7 = document.createElement('td');
                        let cell8 = document.createElement('td');

                        cell1.innerHTML = s_n;
                        cell2.innerHTML = teachersDetails[i].firstname;
                        cell3.innerHTML = teachersDetails[i].surname;
                        if (teachersDetails[i].othername === "NULL" || teachersDetails[i].othername === null || teachersDetails[i] === "") {
                            cell4.innerHTML = 'Nil';
                        } else {
                            cell4.innerHTML = teachersDetails[i].othername;
                        }
                        cell5.innerHTML = teachersDetails[i].qualification;
                        cell6.innerHTML = '<button onclick="viewParent(' + teachersDetails[i].id + ')">view</button>';
                        cell7.innerHTML = '<span><img src="../../statics/images/icons/edit_black_24dp.svg" onclick="editTeacher(' + teachersDetails[i].id + ')"></span>';
                        cell8.innerHTML = '<span><img src="../../statics/images/icons/delete_black_24dp.svg" onclick="deleteTeacher(' + teachersDetails[i].id + ')"></span>';

                        row.appendChild(cell1);
                        row.appendChild(cell2);
                        row.appendChild(cell3);
                        row.appendChild(cell4);
                        row.appendChild(cell5);
                        row.appendChild(cell6);
                        row.appendChild(cell7);
                        row.appendChild(cell8);

                        document.getElementById('view-teachers-table-body').appendChild(row);
                        s_n++;
                    }
                },
                error: function (error){
                    alert(error);
                }
            })
        },
        error: function (serverError){
            alert(serverError);
        }
    })
    hideSideBarMenu();
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

function validateDropDown(selectID, errorPaneID, fieldName){
    const value = document.getElementById(selectID).value;
    if(value.indexOf("Choose")>=0 || value === null || value === ""){
        document.getElementById(errorPaneID).innerHTML = fieldName+" must be selected";
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

const formatTeacherName =(title, firstname, surname, gender, othername)=>{
    var formattedName;
    if(gender === "Male"){
        if(othername === ""){
            formattedName =  title + " "+ firstname.charAt(0).toUpperCase() +". " + surname;
        }else if(othername === null){
            formattedName =  title + " "+ firstname.charAt(0).toUpperCase() +". " + surname;
        }else{
            formattedName = title + " "+ firstname.charAt(0).toUpperCase() +". " + othername.charAt(0).toUpperCase() +". " + surname;
        }
    }else{
        if(othername === ""){
            formattedName =  title + " "+ firstname +". " + surname;
        }else if(othername === null){
            formattedName =  title + " "+ firstname +". " + surname;
        }
        else{
            formattedName = title + " "+ firstname +". " + othername.charAt(0).toUpperCase() +". " + surname;
        }
    }
    return formattedName;
}

function getTeacherFormattedNames(id){
    $.ajax({
        type:'get',
        url:'../../backend/App/getformattedlecturernames.php',
        success: function (response){
            let data = JSON.parse(response);
            for(let i = 0; i<data.length; i++){
                let name = document.createElement('option');
                name.value = data[i].id;
                if (data[i].othername != null && data[i].othername != ""){
                    name.text = formatTeacherName(data[i].title, data[i].firstname, data[i].surname, data[i].gender, data[i].othername);
                }else {
                        name.text = formatTeacherName(data[i].title, data[i].firstname, data[i].surname, data[i].gender,"");
                }
                document.getElementById(id).appendChild(name);
            }
        },
        error: function (error){
            alert(error);
        }
    })
}

function getSubjectsToAssign(){
    $.ajax({
        type:'get',
        url:'../../backend/App/getsubjectstoallocate.php',
        success: function (response){
            let data = JSON.parse(response);
            var tableRow = "";
            var s_n = 0;
            for(let i = 0; i<data.length; i++){
                s_n++;
                if(s_n%2 != 0){
                    tableRow += '<tr class="odd"><td>'+ s_n +'</td><td>' +
                        '<select name="assigned-teacher" id="'+'assigned-teacher'+s_n+'" class="form-input">\n' +
                        '                                        \n' +
                        '                                    </select>' +
                        '</td><td><span>'+data[i].title+'</span><input type="hidden" id="'+'subject_'+s_n+'" value="'+data[i].code+'"><input type="hidden" id="subject_section_'+s_n+'" value="'+data[i].section+'"></td></tr>';
                }else{
                    tableRow += '<tr><td>'+ s_n +'</td><td>' +
                        '<select name="assigned-teacher" id="'+'assigned-teacher'+s_n+'" class="form-input">\n' +
                        '                                        \n' +
                        '                                    </select>' +
                        '</td><td><span>'+data[i].title+'</span><input type="hidden" id="subject_'+s_n+'" value="'+data[i].code+'"><input type="hidden" id="subject_section_'+s_n+'" value="'+data[i].section+'"></td></tr>';
                }
            }
            document.getElementById('subject-assign-table-body').innerHTML = tableRow;
            for (let j = 1; j<=data.length; j++){
                getTeacherFormattedNames('assigned-teacher'+j);
            }
            document.getElementById('table-length').value = s_n;
        },
        error: function (error){
            alert(error);
        }
    })
}

// function validateSubjectUpload(fieldID){
//     if(document.getElementById(fieldID).value === "" || document.getElementById(fieldID).value === null){
//         alert("Error! All fields are compulsory");
//         return;
//     }
// }

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
    if(!validateDropDown('student-section', 'student-section-error', "Pupil's section")){
        return;
    }
    if(!validateTextField('student-state', 'student-state-error', "Pupil's State of origin")){
        return;
    }
    if(!validateTextField('student-lga', 'student-state-error', "Pupil's LGA")){
        return;
    }
    if(!validateDropDown('parent-title', 'parent-title-error', "Parent title")){
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
        passport_id:document.getElementById('passport_id').value,
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
        localStorage.setItem("videoFlag","on");
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
            }
        },
        error: function (error){
            alert(error);
        }
    })
}

function stopCapture(){
    localStream.getVideoTracks()[0].stop();
    video.src = "";
}

function getPassportId(fullPath){
const pathArray = fullPath.split("/");
return pathArray[pathArray.length-1];

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
            if(response == 1 || response == true){
                alert("Passport photograph saved successfully");
                document.getElementById('passport_id').value = getPassportId(formData.get('image'));
                if(localStorage.getItem("videoFlag") === "on"){
                    stopCapture();
                    document.getElementById('passport-area').style.display = "none";
                    document.getElementById('pupil-data').style.display = "block";
                }else{
                    document.getElementById('passport-area').style.display = "none";
                    document.getElementById('pupil-data').style.display = "block";
                }
            }else {
                console.log(response);
            }
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
                let cell7 = document.createElement('td');

                cell1.innerHTML = s_n;
                cell2.innerHTML = pupildata[i].firstname;
                cell3.innerHTML = pupildata[i].surname;
                if (pupildata[i].othername === "NULL" || pupildata[i].othername === null || pupildata[i] === ""){
                    cell4.innerHTML = 'Nil';
                }else{
                    cell4.innerHTML = pupildata[i].othername;
                }
                cell5.innerHTML = '<button onclick="viewParent('+pupildata[i].parent_id+')">view</button>';
                cell6.innerHTML = '<span><img src="../../statics/images/icons/edit_black_24dp.svg" onclick="editStudent('+pupildata[i].id+')"></span>';
                cell7.innerHTML = '<span><img src="../../statics/images/icons/delete_black_24dp.svg" onclick="deleteStudent('+pupildata[i].id+')"></span>';

                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                row.appendChild(cell4);
                row.appendChild(cell5);
                row.appendChild(cell6);
                row.appendChild(cell7);

                document.getElementById('view-table-body').appendChild(row);
                s_n++;
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
                let cell7 = document.createElement('td');

                cell1.innerHTML = s_n+"";
                cell2.innerHTML = pupildata[i].firstname;
                cell3.innerHTML = pupildata[i].surname;
                if (pupildata[i].othername === "NULL" || pupildata[i].othername === null || pupildata[i] === ""){
                    cell4.innerHTML = 'Nil';
                }else{
                    cell4.innerHTML = pupildata[i].othername;
                }
                cell5.innerHTML = '<button onclick="viewParent('+pupildata[i].parent_id+')">view</button>';
                cell6.innerHTML = '<img src="../../statics/images/icons/delete_black_24dp.svg" onclick="editStudent('+pupildata[i].id+')">';
                cell6.innerHTML = '<img src="../../statics/images/icons/delete_black_24dp.svg" onclick="deleteStudent('+pupildata[i].id+')">';

                row.appendChild(cell1);
                row.appendChild(cell2);
                row.appendChild(cell3);
                row.appendChild(cell4);
                row.appendChild(cell5);
                row.appendChild(cell6);
                row.appendChild(cell7);

                document.getElementById('view-table-body').appendChild(row);
                s_n++;
            }
        },
        error: function (error){
            console.log(error);
        }
    })
}

function getStudentsByClass(e){
    const pupilClass = {pupilClass:e.value};
    $.ajax({
        type:'post',
        url: '../../backend/App/get-all-pupil-by-class.php',
        data: pupilClass,
        success: function (response){
            console.log(response);
            // let pupildata = JSON.parse(response);
            // let s_n = 1;
            // document.getElementById('view-table-body').innerHTML = "";
            // for(let i =0; i<pupildata.length; i++) {
            //     let row = document.createElement('tr');
            //     let cell1 = document.createElement('td');
            //     let cell2 = document.createElement('td');
            //     let cell3 = document.createElement('td');
            //     let cell4 = document.createElement('td');
            //     let cell5 = document.createElement('td');
            //     let cell6 = document.createElement('td');
            //
            //     cell1.innerHTML = s_n+"";
            //     cell2.innerHTML = pupildata[i].firstname;
            //     cell3.innerHTML = pupildata[i].surname;
            //     if (pupildata[i].othername === "NULL" || pupildata[i].othername === null || pupildata[i] === ""){
            //         cell4.innerHTML = 'Nil';
            //     }else{
            //         cell4.innerHTML = pupildata[i].othername;
            //     }
            //     cell5.innerHTML = '<img src="../../statics/images/icons/edit_black_24dp.svg">';
            //     cell6.innerHTML = '<img src="../../statics/images/icons/delete_black_24dp.svg">';
            //
            //     row.appendChild(cell1);
            //     row.appendChild(cell2);
            //     row.appendChild(cell3);
            //     row.appendChild(cell4);
            //     row.appendChild(cell5);
            //     row.appendChild(cell6);
            //
            //     document.getElementById('view-table-body').appendChild(row);
            //     s_n++;
            // }
        },
        error: function (error){
            console.log(error);
        }
    })
}

/*********************** Subject Upload Styling****************/

function addSubject(){
    if(subjectCount<5){
        subjectCount++;
        document.getElementById("subject-"+subjectCount).style.display = "block";
        if(subjectCount==5){
            document.getElementById('add-subject-btn-span').style.display = "none";
        }
    }
}

function uploadSubject(){
    const subjects = [];
    for (let i =1; i<=subjectCount; i++){
        const subjectArray = [];
        /**
         * Validate subject title
         */
        if(document.getElementById('subject-title-'+i).value === "" || document.getElementById('subject-title-'+i).value === null){
            alert("Error! All fields are compulsory");
            return;
        }
        subjectArray.push(document.getElementById('subject-title-'+i).value);

        /**
         * Validate subject code
         */
        if(document.getElementById('subject-code-'+i).value === "" || document.getElementById('subject-code-'+i).value === null){
            alert("Error! All fields are compulsory");
            return;
        }
        subjectArray.push(document.getElementById('subject-code-'+i).value);

        if(document.getElementById('subject-section-'+i).value === "" || document.getElementById('subject-section-'+i).value === null){
            alert("Error! All fields are compulsory");
            return;
        }
        subjectArray.push(document.getElementById('subject-section-'+i).value);
        subjects.push(subjectArray);
    }

    $.ajax({
        type:'post',
        url:'../../backend/App/upload-subjects.php',
        data: {subjects:JSON.stringify(subjects)},
        success: function (response){
            if(response === 'success'){
                alert(subjectCount+" Subject(s) uploaded successfully");
            }else{
                alert(response);
            }
        },
        error: function (error){
            alert(error);
        }
    })
}

function createTeacher(){
    /**
     * Validate inputs
     */
    if(!validateDropDown('teacher-title','teacher-title-error','Title')){
        return;
    }
    if(!validateTextField('teacher-firstname', 'teacher-firstname-error','First Name')){
        return;
    }
    if (!validateTextField('teacher-surname','teacher-surname-error', 'Surname')){
        return;
    }
    if(!validateRadioButton('teacher-gender','teacher-gender-error', 'Gender')){
        return;
    }
    if(!validatePhoneNumber('teacher-phone-number','teacher-phone-number-error')){
        return;
    }
    if(!validateEmail('teacher-email', 'teacher-email-error')){
        return;
    }
    if (!validateRadioButton('employment-type','teacher-employment-type-error')){

    }

    const emplomentType = $('input[name = "employment-type"]:checked').val();
    const teacherData = {
        title: document.getElementById('teacher-title').value,
        firstname: document.getElementById('teacher-firstname').value,
        surname: document.getElementById('teacher-surname').value,
        othername: document.getElementById('teacher-othername').value,
        gender: $('input[name = "teacher-gender"]:checked').val(),
        phoneNumber: document.getElementById('teacher-phone-number').value,
        email: document.getElementById('teacher-email').value,
        employmentType: emplomentType,
        teachingType:""
    }
    if(emplomentType === 'Full'){
        if(!validateRadioButton('teaching-type', 'teacher-teaching-type-error')){
            return;
        }
        teacherData.teachingType = $('input[name="teaching-type"]:checked').val();
    }else{
        teacherData.teachingType = 'Subject';
    }

    $.ajax({
        type:'post',
        url:'../../backend/App/create-teacher.php',
        data:teacherData,
        success: function (response){
            alert(response);
        },
        error: function (error){
            alert(error);
        }
    })
}

/************** NEW FEATURES**************/
/************** NEW FEATURES**************/
function assignSubject(){
    const subjectAssignment = [];
    for(let i=1; i<=document.getElementById("table-length").value;i++){
        const subjectTeacher = [];
        subjectTeacher.push(document.getElementById('assigned-teacher'+i).value);
        subjectTeacher.push(document.getElementById('subject_'+i).value);
        subjectTeacher.push(document.getElementById('subject_section_'+i).value);
        subjectAssignment.push(subjectTeacher);
    }

    $.ajax({
        type: 'post',
        url: '../../backend/App/assign-subject.php',
        data: {subjectAssignment:JSON.stringify(subjectAssignment)},
        success:function (response){
            alert(response);
        },
        error:function (error){
            alert(error);
        }
    });
}

function viewParent(id){
    $.ajax({
        type:'post',
        url:'../../backend/App/get-parent-details.php',
        data:{id:id},
        success: function (serverResponse){
            const dataArray = JSON.parse(serverResponse);
            $.ajax({
                type:"GET",
                url:'../admin-uis/view-parent.php',
                success: function (response){
                    const parentTitle = dataArray[0].title;
                    const parentSurname = dataArray[0].surname;
                    const parentFirstname = dataArray[0].firstname;
                    const parentOthername = dataArray[0].othername;
                    const parentGender = dataArray[0].gender;
                    const parentAddress = dataArray[0].address;
                    const parentEmail = dataArray[0].email;
                    const parentOccupation = dataArray[0].occupation;

                    const modal = document.getElementById('main-modal');
                    modal.innerHTML = response;

                    document.getElementById('parentViewTitle').innerHTML = parentTitle;
                    document.getElementById('parentViewSurname').innerHTML = parentSurname;
                    document.getElementById('parentViewFirstname').innerHTML = parentFirstname;
                    document.getElementById('parentViewOthername').innerHTML = parentOthername;
                    document.getElementById('parentViewGender').innerHTML = parentGender;
                    document.getElementById('parentViewAddress').innerHTML = parentAddress;
                    document.getElementById('parentViewEmail').innerHTML = parentEmail;
                    document.getElementById('parentViewOccupation').innerHTML = parentOccupation;
                    modal.style.display = "block";
                }
            })
        },
        error: function (serverError){
            alert(serverError);
        }
    })
}

function editStudent(id){
    alert(id);
}

function deleteStudent(id){
    alert(id);
}


