<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="harkovnet" />
        <title>Login</title>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                    <form action="<?php echo site_url('auth/login'); ?>" method="post">
    <div class="form-floating mb-3">
        <input class="form-control" id="inputEmail" type="email" placeholder="Email" name="email" />
        <label for="inputEmail">Email</label>
    </div>
    <div class="form-floating mb-3">
        <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password" />
        <label for="inputPassword">Password</label>
    </div>
    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
        <button class="btn btn-primary" type="submit" id="button-addon2">Login</button>
    </div>
</form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; PT. Intan Berkat Terang 2023</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('js/scripts.js'); ?>"></script>
    </body>
</html>

<script>
    // Check for success message
    <?php if ($this->session->flashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            showConfirmButton: false,
            timer: 2000 // Duration in milliseconds
        });
    <?php endif; ?>

    // Check for error message
    <?php if ($this->session->flashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            showConfirmButton: false,
            timer: 2000 // Duration in milliseconds
        });
    <?php endif; ?>
</script>

