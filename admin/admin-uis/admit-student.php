        <h3 class="col-12 pane-title">Admit New Student</h3>
        <div class="col-1 form-spacer"></div>
        <div class="col-8" id="admission-form">
            <div class="contentarea" id="passport-area">
                <h3>
                    Take Passport
                </h3>
                <div>
                    <button class="passport-btn" id="run" onclick="startup()">Screen Capture</button><button class="passport-btn" id="passport-from-file-btn" onclick="showPassportFileUpload()">Photo from device</button>
                </div>
                <div class="camera" id="camera-pane">
                    <video id="video">Video stream not available.</video>
                </div>
                <div id="pupil-passport-file-pane">
                    <input type="file" name="pupil-passport-file" class="form-input" id="pupil-passport-file" onchange="previewPassport(this)">
                </div>
                <div id="capture-btn-pane">
                    <button id="capturebtn" onclick="takepicture()">Take photo</button>
                </div>
                <canvas id="canvas"></canvas>
                <div class="output">
                    <img id="photo" alt="Passport will appear in this box.">
                </div>
                <div>
                    <button class="passport-btn" onclick="savePassport()">Save</button><button class="passport-btn" style="background-color: red" onclick="clearphoto()">Clear</button>
                </div>
            </div>

            <!-- Pupil's Data -->

            <div class="pupil-data" id="pupil-data">
                <div>
                    <input type="hidden" name="passport_id" id="passport_id">
                </div>
                <span class="col-12 wrap-form-element">
                    <label>First Name: *</label><br>
                    <input type="text" id="student-firstname" class="form-input">
                </span>
                <div id="student-firstname-error" style="color: red"></div>
                <span class="col-12 wrap-form-element">
                    <label>Surname: *</label><br>
                    <input type="text" id="student-surname" class="form-input">
                </span>
                <div id="student-surname-error" style="color: red"></div>
                <span class="col-12 wrap-form-element">
                    <label>Other Name: </label><br>
                    <input type="text" id="student-othername" class="form-input">
                </span>
                <span class="col-12 wrap-form-element">
                    <label>Gender: *</label><br>
                    <input type="radio" name="student-gender" id="student-gender-male" value="Male"><label for="student-gender-male">Male</label>
                    <input type="radio" name="student-gender" id="student-gender-female" value="Female"><label for="student-gender-female">Female</label>
                </span>
                <div id="student-gender-error" style="color: red"></div>
                <span class="col-12 wrap-form-element">
                    <label>Class Admitted Into: *</label><br>
                    <input type="text" id="student-class" class="form-input">
                </span>
                <div id="student-class-error" style="color: red"></div>
                <span class="col-12 wrap-form-element">
                    <label>Date of Birth: *</label><br>
                    <input type="date" id="student-dob" class="form-input">
                </span>
                <div id="student-dob-error" style="color: red"></div>

                <span class="col-12 wrap-form-element">
                    <label>Section: *</label><br>
                    <select id="student-section" class="form-input">
                        <option>Choose Section</option>
                        <option value="creche">Creche</option>
                        <option value="pre-nursery">Pre-Nursery</option>
                        <option value="nursery">Nursery</option>
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                    </select>
                </span>
                <div id="student-section-error" style="color: red"></div>

                <span class="col-12 wrap-form-element">
                    <label>State OF Origin: *</label><br>
                    <select id="student-state" class="form-input" onchange="getLGAs('student-lga')">
                        <option>Choose State of Origin</option>
                    </select>
                </span>
                <div id="student-state-error" style="color: red"></div>

                <span class="col-12 wrap-form-element">
                    <label>LGA of Origin: *</label><br>
                    <select id="student-lga" class="form-input">
                        <option>Choose LGA</option>
                    </select>
                </span>
                <div id="student-lga-error" style="color: red"></div>
                <!-- Parent Details for student/pupil admission -->

                <h4 id="parent-data-header">Add Parent Details * <img src="../../statics/images/icons/add_black_24dp.svg"  id="add-parent-btn" onclick="showParentForm()"></h4>
                <div class="col-12" id="parent-data-pane">
                <span class="col-12 wrap-form-element">
                    <label>Title: *</label><br>
                    <select name="parent-title" id="parent-title" class="form-input">
                        <option>Choose title</option>
                    </select>
                </span>
                    <div id="parent-title-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>First Name: *</label><br>
                    <input type="text" id="parent-firstname" class="form-input">
                </span>
                    <div id="parent-firstname-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>Surname: *</label><br>
                    <input type="text" id="parent-surname" class="form-input">
                </span>
                    <div id="parent-surname-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>Other Name: </label><br>
                    <input type="text" id="parent-othername" class="form-input">
                </span>

                    <span class="col-12 wrap-form-element">
                    <label>Gender: *</label><br>
                    <input type="radio" name="parent-gender" id="parent-gender-male" value="Male" class="form-input"><label for="parent-gender-male">Male</label>
                    <input type="radio" name="parent-gender" id="parent-gender-female" value="Female" class="form-input"><label for="parent-gender-female">Female</label>
                </span>
                    <div id="parent-gender-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>Mobile Phone Number: *</label><br>
                    <input type="text" id="parent-phone-number" class="form-input">
                </span>
                    <div id="parent-phone-number-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>Email: *</label><br>
                    <input type="email" id="parent-email" class="form-input">
                </span>
                    <div id="parent-email-error" style="color: red"></div>

                    <span class="col-12 wrap-form-element">
                    <label>Occupation: *</label><br>
                    <input type="text" id="occupation" class="form-input">
                </span>

                    <div id="occupation-error" style="color: red"></div>
                    <span class="col-12 wrap-form-element">
                    <button id="submit-btn" class="form-input" onclick="admitStudent()">Submit</button>
                </span>
                </div>
            </div>
