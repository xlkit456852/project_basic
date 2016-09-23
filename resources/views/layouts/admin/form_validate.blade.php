<!-- validator -->
<script>
    // initialize the validator function
    validator.message.empty = '该项不能为空！';
    validator.message.number_min = '数值太小！';
    validator.message.number_max = '数值太大！';

    /*message = {
        invalid         : 'invalid input',
        checked         : 'must be checked',
        empty           : 'please put something here',
        min             : 'input is too short',
        max             : 'input is too long',
        number_min      : 'too low',
        number_max      : 'too high',
        url             : 'invalid URL',
        number          : 'not a number',
        email           : 'email address is invalid',
        email_repeat    : 'emails do not match',
        password_repeat : 'passwords do not match',
        repeat          : 'no match',
        complete        : 'input is not complete',
        select          : 'Please select an option'
    };*/

    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('#edit_form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

    $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
    });

    $('#edit_form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }

        if (submit)
            this.submit();

        return false;
    });
</script>
<!-- /validator -->