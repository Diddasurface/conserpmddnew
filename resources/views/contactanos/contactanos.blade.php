@extends('recursos.barras')
@section('title', 'Contáctanos | ConserpMDD')
@section('description', 'Contacta a ConserpMDD para solicitar asesoría en seguridad y salud en el trabajo, auditorías y normas ISO. Atención en Puerto Maldonado, Perú.')
@section('contactanos')
    <div class="rbt-newsletter-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9 col-12">
                    <div class="rbt-contact-form contact-form-style-1 mx-auto" style="max-width: 900px;">
                        <h3 class="title text-center">Contáctanos</h3>
                        <form action="" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Nombre -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="nombre" type="text" required>
                                        <label>Nombre</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <!-- Correo -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input name="email" type="email" required>
                                        <label>Correo Electrónico</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <!-- Asunto -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <input name="asunto" type="text" required>
                                        <label>Asunto</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <!-- Mensaje -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="mensaje" rows="4" required></textarea>
                                        <label>Mensaje</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <!-- Botón -->
                                <div class="col-12 text-center">
                                    <div class="form-submit-group">
                                        <button type="submit"
                                            class="rbt-btn btn-md btn-gradient hover-icon-reverse radius-round w-100">
                                            <span class="icon-reverse-wrapper">
                                                <span class="btn-text">Enviar Mensaje</span>
                                                <span class="btn-icon"><i class="feather-send"></i></span>
                                                <span class="btn-icon"><i class="feather-send"></i></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="row mt--60">
                <div class="col-12">
                    <div class="mapouter">
                        <div class="gmap_canvas" style="width: 100%; height: 400px;">
                            <iframe width="100%" height="100%" id="gmap_canvas"
                                src="https://maps.google.com/maps?q=Jr.%2028%20de%20Julio%20440,%20Puerto%20Maldonado&t=&z=15&ie=UTF8&iwloc=&output=embed"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
