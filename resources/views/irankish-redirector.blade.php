<html>
<body>
<script>
    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "https://ikc.shaparak.ir/TPayment/Payment/index");
    form.setAttribute("target", "_self");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "token");
    hiddenField.setAttribute("value", "{{$refId}}");
    var hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("name", "merchantId");
    hiddenField2.setAttribute("value", "{{$merchantId}}");
    form.appendChild(hiddenField);
    form.appendChild(hiddenField2);
    document.body.appendChild(form);
    form.submit();
</script>
</body>
</html>