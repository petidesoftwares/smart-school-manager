<h3 class="col-12 pane-title">Register New Teacher</h3>
    <div class="col-1 form-spacer"></div>
    <div class="col-8" id="admission-form">
        <span class="col-12 wrap-form-element">
            <label>Title: *</label>
            <select name="teacher-title" id="teacher-title" class="form-input">
                <option>Choose Title</option>
            </select>
        </span>
        <div id="teacher-title-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>First Name: *</label>
            <input type="text" name="teacher-firstname" id="teacher-firstname" class="form-input">
        </span>
        <div id="teacher-firstname-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>Surname: *</label>
            <input type="text" name="teacher-surname" id="teacher-surname" class="form-input">
        </span>
        <div id="teacher-surname-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>Other Name: </label>
            <input type="text" name="teacher-othername" id="teacher-othername" class="form-input">
        </span>
        <span class="col-12 wrap-form-element">
            <label>Gender: *</label><br>
            <input type="radio" name="teacher-gender" id="teacher-male" value="Male"><label for="teacher-male">Male</label>
            <input type="radio" name="teacher-gender" id="teacher-female" value="Female"><label for="teacher-female">Female</label>
        </span>
        <div id="teacher-gender-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>Phone Number: *</label>
            <input type="text" name="teacher-phone-number" id="teacher-phone-number" class="form-input">
        </span>
        <div id="teacher-phone-number-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>Email: *</label>
            <input type="email" name="teacher-email" id="teacher-email" class="form-input">
        </span>
        <div id="teacher-email-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <label>Employment Type: *</label><br>
            <input type="radio" name="employment-type" id="fulltime-employment-type" value="Full Time" onclick="showTeachingType()"><label>Full-Time</label>
            <input type="radio" name="employment-type" id="parttime-employment-type" value="Part Time" onclick="hideTeachingType()"><label>Part-Time</label>
        </span>
        <div id="teacher-employment-type-error" style="color: red"></div>
        <span class="col-12 wrap-form-element" id="teaching-type-pane">
            <label>Teaching Type: *</label><br>
            <input type="radio" name="teaching-type" id="subject-teaching-type" value="Subject"><label>Subject</label>
            <input type="radio" name="teaching-type" id="class-teaching-type" value="Class"><label>Class</label>
        </span>
        <div id="teacher-teaching-type-error" style="color: red"></div>
        <span class="col-12 wrap-form-element">
            <button onclick="createTeacher()">Submit</button>
        </span>
    </div>