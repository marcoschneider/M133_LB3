$(function(){

  customSelect('#dropdown-register');
  customSelect('#todo-type');
  customSelect('#project');

  $('#update-link-submit').on("click", function () {
    var supportLinkID = $('.link-id');
    var linkToUpdate = $('#link-to-update').val();
    var updateInputSubmit = '<input type="submit" name="update-link" class="button-default" value="Link aktualisieren">';
    supportLinkID.each(function (i) {
      if (supportLinkID[i].innerHTML === linkToUpdate) {

        var hiddenLinkIdInput = '<input type="hidden" name="link_id" value="'+linkToUpdate+'">';

        let nameOfLink = $(supportLinkID[i]).parent().text();
        let refOfLink = $(supportLinkID[i]).parent().attr("href");
        
        nameOfLink = nameOfLink.replace(linkToUpdate, '');

        $('#name-link').val(nameOfLink);
        $('#link-url').val(refOfLink);

        $('#add-link-title').text("Link bearbeiten");

        $('#update-link-trigger').replaceWith(updateInputSubmit);
        $('#add-link').append(hiddenLinkIdInput);
      }else{

      }
    });
  });

});

function customSelect(elementID) {

  $(elementID).on("click", function () {
    $(".dropdown-list").slideToggle(250, function () {
      $(this).toggleClass("block");
    });
    return false;
  });

  var dropdownLists = elementID+' .dropdown-list';

  $(dropdownLists+' li').on("click", function () {
    var liText = $(this).text();
    var liData = $(this).data("list-value");
    var name = $(dropdownLists).data('name');

    liData = liText + "<input type=\"hidden\" name='" + name + "' value='" + liData + "'/>";
    $(elementID+' p').html(liData);
  });
}