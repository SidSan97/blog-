<?php
    use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Sid Blog</title>

    <link rel="stylesheet" href="css/styles.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
  </head>

  <body>
    <!-- sidebar starts -->
    <div class="sidebar">
      <i class="fab fa-twitter"></i>
      <div class="sidebarOption active">
        <span class="material-icons"> home </span>
        <h2>Home</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> search </span>
        <h2>Explore</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> notifications_none </span>
        <h2>Notifications</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> mail_outline </span>
        <h2>Messages</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> bookmark_border </span>
        <h2>Bookmarks</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> list_alt </span>
        <h2>Lists</h2>
      </div>

      <div class="sidebarOption">
        <span class="material-icons"> perm_identity </span>
        <h2><a href="/user/profile">Profile</a></h2>
      </div>

      @auth
      <div class="sidebarOption">
        <span class="material-icons"> perm_identity </span>
        <form action="/logout" method="post">
            @csrf
            <h2 onclick="event.preventDefault(); this.closest('form').submit();">
                <a href="/logout">Sair</a>
            </h2>
        </form>
      </div>
      @endauth
    </div>
    <!-- sidebar ends -->

    <!-- feed starts -->
    <div class="feed">
      <div class="feed__header">
        <h2>Página Inicial</h2>
      </div>

      <!-- tweetbox starts -->
      <div class="tweetBox">
        <form action="/postar" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="tweetbox__input">
                <img src="https://i.pinimg.com/originals/a6/58/32/a65832155622ac173337874f02b218fb.png" alt=""/>

                <textarea name="texto" class="form-control" id="textArea" placeholder="No que você está pensando?" required> </textarea>
            </div>

            <input type="hidden" name="autor" id="" value="<?php echo Auth::user()->name; ?>">
            <input type="hidden" name="id_autor" id="" value="<?php echo Auth::id(); ?>">

            <div class="button-form">
                <input type="file" placeholder="imagem" name="imagem">
                <button type="submit" name="postar" class="tweetBox__tweetButton">Postar</button>
            </div>
        </form>
      </div>
      <!-- tweetbox ends -->

      <!-- post starts -->
      @foreach($posts as $postagem)
      <div class="post">
        <div class="post__avatar">
          <img
            src="https://i.pinimg.com/originals/a6/58/32/a65832155622ac173337874f02b218fb.png"
            alt=""
          />
        </div>

        <div class="post__body">
          <div class="post__header">
            <div class="post_header1">
                <div class="post__headerText">
                    <h3> {{ $postagem->autor }} </h3>

                    <span class="dataPost">Postado em: {{ $postagem->created_at }}</span> <br><br>
                </div>

                <div class="divMoreOptions" data-bs-toggle="modal" href="#modalOpcoes{{$postagem->id}}">
                    <img src="img/more-information.png" alt="Mais Informações" width="16px" height="16px" srcset="">
                </div>

                <!-- Modal opçoes-->
                <div class="modal fade" id="modalOpcoes{{$postagem->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Opções</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <ul class="lista-opcoes" style="padding-left: 0px;">
                                    @if($postagem->id_autor == Auth::id())
                                    <li><span data-bs-target="#modalEdicao{{$postagem->id}}" data-bs-toggle="modal" data-bs-dismiss="modal">Editar</span></li>
                                    <li><span data-bs-target="#modalExclusao{{$postagem->id}}" data-bs-toggle="modal" data-bs-dismiss="modal">Excluir</span></li>
                                    @endif
                                    <li><span>Denunciar</span></li>
                                    <li><span data-bs-toggle="modal" data-bs-dismiss="modal">Cancelar</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal exclusao-->
                <div class="modal fade" id="modalExclusao{{$postagem->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Tem certeza que quer excluir o post?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-target="#modalOpcoes{{$postagem->id}}" data-bs-toggle="modal" data-bs-dismiss="modal"> Não </button>

                                <button type="button" class="btn btn-danger">
                                    <a href="excluir/{{$postagem->id}}">Sim</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal edição-->
                <div class="modal fade" id="modalEdicao{{$postagem->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Editar Publicação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="/editar/{{$postagem->id}}" method="GET">
                                    <textarea class="form-control" name="texto" id="areaEdicao">
                                        {{$postagem->texto}}
                                    </textarea>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="post__headerDescription">
              <p>{{ $postagem->texto }}</p>
            </div>
          </div>

          <img src="/img/posts/{{$postagem->imagem}}" alt=""/>

          <div class="post__footer">
            <span class="material-icons"> repeat </span>
            <span class="material-icons"> favorite_border </span>
            <span class="material-icons"> publish </span>
          </div>
        </div>
      </div>
      @endforeach
      <!-- post ends -->
    </div>
    <!-- feed ends -->

    <!-- widgets starts -->
    <div class="widgets">
      <div class="widgets__input">
        <span class="material-icons widgets__searchIcon"> search </span>
        <input type="text" placeholder="Procurar no SidBlog" />
      </div>

      <div class="widgets__widgetContainer">
        <h2>Destaques</h2>
        <blockquote class="twitter-tweet">
          <p lang="en" dir="ltr">
            Sunsets don&#39;t get much better than this one over
            <a href="https://twitter.com/GrandTetonNPS?ref_src=twsrc%5Etfw">@GrandTetonNPS</a>.
            <a href="https://twitter.com/hashtag/nature?src=hash&amp;ref_src=twsrc%5Etfw"
              >#nature</a
            >
            <a href="https://twitter.com/hashtag/sunset?src=hash&amp;ref_src=twsrc%5Etfw"
              >#sunset</a
            >
            <a href="http://t.co/YuKy2rcjyU">pic.twitter.com/YuKy2rcjyU</a>
          </p>
          &mdash; US Department of the Interior (@Interior)
          <a href="https://twitter.com/Interior/status/463440424141459456?ref_src=twsrc%5Etfw"
            >May 5, 2014</a
          >
        </blockquote>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
      </div>
    </div>
    <!-- widgets ends -->

    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
