<h4 class="col-12 pane-title">View Students/Pupils</h4>
<div class="view-categories">
    <span class="category-pane">
        <input type="radio" name="pupil-student-view-category" id="view-all-pupil-student" value="all" onclick="selectViewCategory(this)"> <label for="view-all-pupil-student">All</label>
    </span>
    <span class="category-pane">
        <input type="radio" name="pupil-student-view-category" id="view-by-section" value="section" onclick="selectViewCategory(this)"> <label for="view-by-section">By Section</label>
        <select name="section-category" id="section-category" onchange="getStudentsBySection(this)">
            <option>Choose Section</option>
            <option value="creche">Creche</option>
            <option value="nursery">Nursery</option>
            <option value="primary">Primary</option>
            <option value="secondary">Secondary</option>
        </select>
    </span>
    <span class="category-pane">
        <input type="radio" name="pupil-student-view-category" id="view-by-class" value="class" onclick="selectViewCategory(this)"> <label for="view-by-class">By class</label>
        <select name="class-category" id="class-category" onchange="getStudentsByClass(this)">
            <option>Choose Class</option>
            <option value="creche">Creche</option>
            <option value="pre-nursery">Pre-nursery</option>
            <option value="nursery-1">Nursery 1</option>
            <option value="nursery-2">Nursery 2</option>
            <option value="nursery-3">Nursery 3</option>
            <option value="primary-1">Primary 1</option>
            <option value="primary-2">Primary 2</option>
            <option value="primary-3">Primary 3</option>
            <option value="primary-4">Primary 4</option>
            <option value="primary-5">Primary 5</option>
            <option value="jss-1">JSS 1</option>
            <option value="jss-2">JSS 2</option>
            <option value="jss-3">JSS 3</option>
            <option value="sss-1">SSS 1</option>
            <option value="sss-2">SSS 2</option>
            <option value="sss-3">SSS 3</option>
        </select>
    </span>
</div>
<div class="col-12 view-record-pane" id="view-record-pane">
    <table class="record-display-table">
        <thead>
            <th>S/N</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>Other Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody class="view-table-body" id="view-table-body"></tbody>
    </table>

</div>