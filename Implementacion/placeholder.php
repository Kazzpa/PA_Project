<!--<script type="text/javascript">
    $(document).ready(function () {

        $('input[placeholder]').placeholderLabel({
            placeholderColor: "#898989", // Color placeholder
            labelColor: "#4AA2CC", // Color label (after the focus)
            labelSize: "14px", // Size of label (after the focus)
            useBorderColor: true, // If true a border input is altered after focus
            inInput: true, // If true the label is actually in half vertically
            timeMove: 200 // Time effect move after focus
        });
    });</script>-->
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/jquery.placeholder.label.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[placeholder]').placeholderLabel();
    });
</script>