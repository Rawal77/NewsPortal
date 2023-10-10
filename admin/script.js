
$(document).ready(function() {
    // Function to handle the change event of the role dropdown
    $("#role").change(function() {
        var selectedRole = $(this).val();
        var additionalFieldsDiv = $("#additionalFields");

        if (selectedRole === "1" || selectedRole === "2") {
            additionalFieldsDiv.show();
        } else {
            additionalFieldsDiv.hide();
        }
    });
});
