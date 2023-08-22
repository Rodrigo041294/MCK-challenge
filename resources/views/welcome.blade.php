<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estados de México</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
</head>
<body>
    <main class="flex-shrink-0">
        <div class="container">
          <h1 class="mt-5">Estados de México</h1>
          <p class="lead">Información obtenida de Servicio Web del Catálogo Único de Claves Geoestadísticas</p>
          <p>Ejercicio realizado por: <a href="#">Rodrigo Eduardo Rodriguez Araiza</a></p>
        </div>
        <div class="container">
            <button class="btn btn-outline-primary" onclick="sincronizarDatosINEGI()">Sincronizar Datos de INEGI</button>
            <div class="row p-5">
                <div class="col">
                    <table id="myTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Clave de AGEE</th>
                                <th>Nombre de AGEE</th>
                                <th>Nombre abreviado de AGEE</th>
                                <th>Población total</th>
                                <th>Población masculina</th>
                                <th>Población femenina</th>
                                <th>Total de viviendas habitadas</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($states as $state)
                                <tr>
                                    <td>{{$state['cvegeo']}}</td>
                                    <td>{{$state['nom_agee']}}</td>
                                    <td>{{$state['nom_abrev']}}</td>
                                    <td>{{$state['pob']}}</td>
                                    <td>{{$state['pob_fem']}}</td>
                                    <td>{{$state['pob_mas']}}</td>
                                    <td>{{$state['viv']}}</td>
                                    <td><button type="button" class="btn btn-outline-primary" onclick="getInfo('{{$state['cvegeo']}}')"><i class="bi bi-info-circle"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
      </main>
      <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="titleModal"></h5>
            </div>
            <div class="modal-body">
            </div>
          </div>
        </div>
      </div>
      <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
          <span class="text-muted">MCK Agency 22 Agosto 2023</span>
        </div>
      </footer>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready( function () {
        $('#myTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            }
        });
    });
    function getInfo(cvegeo) {
        $('#infoModal').modal('show');
        // ajax
        $.ajax({
            url: '/getInfo/'+cvegeo,
            type: 'GET',
            data: {
                cvegeo: cvegeo,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $('#titleModal').html(response['data']['nom_agee']);
                $('#infoModal .modal-body').html(`
                    <p><strong>Clave de AGEE:</strong> ${response['data']['cvegeo']}</p>
                    <p><strong>Nombre de AGEE:</strong> ${response['data']['nom_agee']}</p>
                    <p><strong>Nombre abreviado de AGEE:</strong> ${response['data']['nom_abrev']}</p>
                    <p><strong>Población total:</strong> ${response['data']['pob']}</p>
                    <p><strong>Población masculina:</strong> ${response['data']['pob_fem']}</p>
                    <p><strong>Población femenina:</strong> ${response['data']['pob_mas']}</p>
                    <p><strong>Total de viviendas habitadas:</strong> ${response['data']['viv']}</p>
                `);
            }
        });
    }
    function sincronizarDatosINEGI () {
        Swal.showLoading();
        $.ajax({
            url: '/sincronizarDatosINEGI',
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response['status'] == 'success') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se han sincronizado los datos correctamente, por favor actualiza la página',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'danger',
                        title: 'ocurrio un error, por favor intentalo más tarde',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            Swal.hideLoading()
            }
        });
    }
</script>
</html>
