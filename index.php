<!DOCTYPE html>
<html>
<head>
    <title>VOTACIONES</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">

        <div class="row">
            <div class="col-md-6">
                
                    <h2>Formulario de Votación</h2>

                    <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" name="nombres" class="form-control" id="nombres" required>
                    </div>

                    <div class="form-group">
                        <label>Rut</label>
                        <input type="text" id="rut" name="rut" oninput="checkRut(this)" class="form-control" required maxlength="10">
                    </div>

                    <div class="form-group">
                        <label>Alias</label>
                        <input type="text" name="alias" class="form-control" minlength="5" id="alias" required onkeypress="filtrarLetrasNumeros(event)" onpaste="return false;">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>

                    <div class="form-group">
                        <label>Región</label>
                        <select name="regiones" id="regiones" class="form-control">
                            <?php include 'regiones.php'; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Comuna</label>
                        <select name="comunas" id="comunas" class="form-control">
                            <?php include 'comunas.php'; //Arica = 1 ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Candidato</label>
                        <select name="candidato" id="candidato" class="form-control">
                            <?php include 'candidatos.php'; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>¿Como se enteró de nosotros?</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="1" name="chk">
                            <label class="form-check-label" for="inlineCheckbox1">Sitio Web</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="2" name="chk">
                            <label class="form-check-label" for="inlineCheckbox2">TV</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="3" name="chk">
                            <label class="form-check-label" for="inlineCheckbox3">Redes Sociales</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="4" name="chk">
                            <label class="form-check-label" for="inlineCheckbox3">Amigo</label>
                        </div>
                    </div>

                    <button id="agregar" type="submit" class="btn btn-primary btn-lg btn-block">VOTAR</button>
                
            </div>
        </div>
    </div>

    <script>

        $( document ).ready(function() {

            $("#agregar").click(function() {
                if (confirm("¿Deseas agregar este registro?")) {

                    var numberNotChecked = $('input:checkbox:not(":checked")').length;

                    var checks = new Array();
                    $('.form-check-input:checked').each(function(){
                        checks.push($(this).val());
                    });

                    console.log("ans-> ", checks.join());
                    //return false;

                    if( $("#nombres").val().length === 0 ) {
                        alert("Debe ingresar nombre y apellido.");
                        $("#nombres").focus();
                        return false;
                    }

                    if( $("#rut").val().length === 0 ) {
                        alert("Debe ingresar el rut.");
                        $("#rut").focus();
                        return false;
                    }

                    if( $("#alias").val().length === 0 ) {
                        alert("Debe ingresar el alias.");
                        $("#alias").focus();
                        return false;
                    }

                    if( $('#alias').val().length < 5 ) {
                        alert("El alias debe tener más de 5 caracteres.");
                        $("#alias").focus();
                        return false;
                    }

                    if( $("#email").val().length === 0 ) {
                        alert("Debe ingresar un email.");
                        $("#email").focus();
                        return false;
                    }

                    if(!checkEmail($("#email").val())) {
                        alert("Ingrese un email correcto.");
                        $("#email").val("").focus();
                        return false;
                    }

                    if(numberNotChecked > 2){
                        alert("¿Como nos conociste? selecciona al menos dos opciones.");
                        return false;
                    }

                    $.ajax({
                        type:'POST',
                        data:{
                                nombres: $("#nombres").val(),
                                rut: $("#rut").val(),
                                alias: $("#alias").val(),
                                email: $("#email").val(),
                                checks: checks,
                                candidato: $("#candidato").val(),
                                comunas: $("#comunas").val(),
                                regiones: $("#regiones").val()
                            },
                        url:'agregar.php',
                        success:function(data) {
                            console.log("data= ", data);
                            if(data == 1){
                                alert("El rut ya existe en la base de datos.");
                            }else{
                                alert("Voto ingresado.");
                                //window.location.reload();
                            }
                        }
                    });

                } else {
                    return false;
                }
            });

            $("#regiones").change(function() {
                var optionSelected = $(this).find("option:selected");
                var ordinal_region  = optionSelected.val();
                $.ajax({
                    method: "POST",
                    url: "comunas.php",
                    data: { ordinal_region: ordinal_region}
                })
                .done(function( comunas ) {
                    $("#comunas").html("");
                    $("#comunas").html(comunas);
                });
            });

        });

        function checkEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        function filtrarLetrasNumeros(e) {
            var regex = new RegExp("^[a-zA-Z0-9 ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        }

        function checkRut(rut) {
            // Despejar Puntos
            var valor = rut.value.replace('.','');
            // Despejar Guión
            valor = valor.replace('-','');

            // Aislar Cuerpo y Dígito Verificador
            cuerpo = valor.slice(0,-1);
            dv = valor.slice(-1).toUpperCase();

            // Formatear RUN
            rut.value = cuerpo + '-'+ dv

            // Si no cumple con el mínimo ej. (n.nnn.nnn)
            if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}

            // Calcular Dígito Verificador
            suma = 0;
            multiplo = 2;

            // Para cada dígito del Cuerpo
            for(i=1;i<=cuerpo.length;i++) {

                // Obtener su Producto con el Múltiplo Correspondiente
                index = multiplo * valor.charAt(cuerpo.length - i);

                // Sumar al Contador General
                suma = suma + index;

                // Consolidar Múltiplo dentro del rango [2,7]
                if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

            }

            // Calcular Dígito Verificador en base al Módulo 11
            dvEsperado = 11 - (suma % 11);

            // Casos Especiales (0 y K)
            dv = (dv == 'K')?10:dv;
            dv = (dv == 0)?11:dv;

            // Validar que el Cuerpo coincide con su Dígito Verificador
            if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }

            // Si todo sale bien, eliminar errores (decretar que es válido)
            rut.setCustomValidity('');
        }
    </script>

</body>
</html>