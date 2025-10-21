<?php
/* Template Name: Peças e Consumíveis */

get_header(); 
?>

<div class="container-fluid bradcamp">
  <?php //custom_breadcrumbs(); ?>
</div>

  <div class="container titulo">
    <h2>Peças e Consumíveis</h2>
  </div>
<main class="container my-5">





    <div class="container my-5">
    <div class="row">

        <aside class="col-md-3">
            <div class="card shadow-sm" style="border-top: 5px solid #103c64;">
                <div class="card-body">
                    <h4 class="card-title mb-3" style="color: #103c64;">Categorias</h4>
                    <div class="list-group list-group-flush category-sidebar">
                        <a href="/sua-categoria-1" class="list-group-item list-group-item-action">
                            <i class="fas fa-filter me-2" style="color: #103c64;"></i> Filtros
                        </a>
                        <a href="/sua-categoria-2" class="list-group-item list-group-item-action">
                            <i class="fas fa-compact-disc me-2" style="color: #103c64;"></i> Freios
                        </a>
                        <a href="/sua-categoria-3" class="list-group-item list-group-item-action">
                            <i class="fas fa-cogs me-2" style="color: #103c64;"></i> Motor
                        </a>
                        <a href="/sua-categoria-4" class="list-group-item list-group-item-action">
                            <i class="fas fa-car-battery me-2" style="color: #103c64;"></i> Suspensão
                        </a>
                        <a href="/sua-categoria-5" class="list-group-item list-group-item-action">
                            <i class="fas fa-bolt me-2" style="color: #103c64;"></i> Elétrica
                        </a>
                        <a href="/sua-categoria-6" class="list-group-item list-group-item-action">
                            <i class="fas fa-windshield me-2" style="color: #103c64;"></i> Consumíveis
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <main class="col-md-9">
            <section id="produtos-destaque">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ordenar por
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Relevância</a></li>
                            <li><a class="dropdown-item" href="#">Menor Preço</a></li>
                            <li><a class="dropdown-item" href="#">Maior Preço</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm product-card">
                            <img src="https://via.placeholder.com/300x300/f8f9fa/103c64?text=Produto+1" class="card-img-top" alt="Nome do Produto 1">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="color: #103c64;">Pastilha de Freio Cerâmica</h5>
                                <p class="card-text text-muted">Código: ABC-12345</p>
                                <p class="card-text flex-grow-1">Alta performance e durabilidade para frenagens seguras.</p>
                                <a href="/link-para-produto-1" class="btn btn-primary mt-auto" style="background-color: #103c64; border-color: #103c64;">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm product-card">
                            <img src="https://via.placeholder.com/300x300/f8f9fa/103c64?text=Produto+2" class="card-img-top" alt="Nome do Produto 2">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="color: #103c64;">Filtro de Óleo Premium</h5>
                                <p class="card-text text-muted">Código: XYZ-67890</p>
                                <p class="card-text flex-grow-1">Máxima eficiência na filtragem para proteger seu motor.</p>
                                <a href="/link-para-produto-2" class="btn btn-primary mt-auto" style="background-color: #103c64; border-color: #103c64;">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm product-card">
                            <img src="https://via.placeholder.com/300x300/f8f9fa/103c64?text=Produto+3" class="card-img-top" alt="Nome do Produto 3">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="color: #103c64;">Amortecedor Turbo Gás</h5>
                                <p class="card-text text-muted">Código: MNO-11223</p>
                                <p class="card-text flex-grow-1">Conforto e estabilidade em qualquer tipo de terreno.</p>
                                <a href="/link-para-produto-3" class="btn btn-primary mt-auto" style="background-color: #103c64; border-color: #103c64;">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm product-card">
                            <img src="https://via.placeholder.com/300x300/f8f9fa/103c64?text=Produto+4" class="card-img-top" alt="Nome do Produto 4">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title" style="color: #103c64;">Vela de Ignição Iridium</h5>
                                <p class="card-text text-muted">Código: PQR-44556</p>
                                <p class="card-text flex-grow-1">Melhora a partida a frio e a queima de combustível.</p>
                                <a href="/link-para-produto-4" class="btn btn-primary mt-auto" style="background-color: #103c64; border-color: #103c64;">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                    
                    </div>
            </section>
        </main>

    </div>
</div>

</main>
<?php get_footer(); ?>