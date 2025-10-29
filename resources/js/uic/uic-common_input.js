$(document).on("input blur", ".UICCommonInput-IsMandatoryInputJQ", function () {
    let inputElement = $(this);
    let inputValue = inputElement.val().trim();

    let errorBox = inputElement.closest(".dUICCommonInputContainerJQ")
        .find(".dUICCommonInput-MessageContainerJQ p")

    if (inputValue === ""){
        inputElement.css("outline", "solid .15em #b21515");
        errorBox.text("required");
    }
    else
    {
        inputElement.css("outline", "none");
        errorBox.text("");
    }
});