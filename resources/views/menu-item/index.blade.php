<x-app-layout>
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $breadcrumb['classes'] }}"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ $pageTitle }}</h1>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="primary-wrapper transparent-pw">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Menu Items overzicht
                            </span>

                             <div class="float-right">
                                <a href="{{ route('menu-items.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

										<th>Name</th>
										<th>Url</th>
										<th>Parent Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menuItems as $menuItem)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $menuItem->name }}</td>
											<td>{{ $menuItem->url }}</td>
											<td>{{ $menuItem->parent_id }}</td>

                                            <td>
                                                <form action="{{ route('menu-items.destroy',$menuItem->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('menu-items.show',$menuItem->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('menu-items.edit',$menuItem->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $menuItems->links() !!}
            </div>
        </div>
        <div class="primary-wrapper transparent-pw">
        <div class="row gx-5">
            <div class="col">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Volgorde van het menu aanpassen
                            </span>
                    </div>
                </div>
                <div class="col p-3">
                    <p>Om de volgorde van het menu aan te passen, kun je het getal aanpassen dat links van elk menu-item staat.
                        Als je een submenu item aanpast, geldt de volgorde alleen voor de items in dat submenu. Om een volledige submenu te verplaatsen,
                        moet je de bovenliggende (parent) van het submenu aanpassen. Het laagste getal is 0.</p>
                <form class="edit-menu-form" method="POST" action="{{ route('menu-items.saveMenu') }}">
                    @csrf
                    <ul class="edit-menu-ul nav flex-column">
                        @foreach ($selectMenuItems as $selectMenuItem)
                            <li class="edit-menu-item nav-item">
                                <div class="menu-item-div">
                                <input type="text" name="orders[{{ $selectMenuItem->id }}]" value="{{ $selectMenuItem->order }}" class="order-input">
                                <span class="parent p-3">
                                    {{ $selectMenuItem->name }}
                                    <a class="btn btn-sm btn-success float-right" href="{{ route('menu-items.edit',$selectMenuItem->id) }}"><i class="fa fa-fw fa-edit"></i></a>
                                </span>
                                </div>
                                @if ($selectMenuItem->children)
                                    <ul class="nav flex-column">
                                        @foreach ($selectMenuItem->children as $selectMenuChild)
                                            <li class="nav-item edit-menu-item">
                                                <div class="menu-item-div child-block">
                                                    <input type="text" name="orders[{{ $selectMenuChild->id }}]" value="{{ $selectMenuChild->order }}" class="order-input">
                                                    <span class="child p-3">
                                                    {{ $selectMenuChild->name }}
                                                        <a class="btn btn-sm btn-success float-right" href="{{ route('menu-items.edit',$selectMenuChild->id) }}"><i class="fa fa-fw fa-edit"></i></a>
                                                </span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <button class="btn btn-primary btn-lg" type="submit">Opslaan</button>
                </form>

                </div>
        </div>
        </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               Voorbeeld van de menustructuur
                            </span>
                        </div>
                    </div>
                    <div class="col p-3">

                        <div class="container" style="margin:30px 0px;">

                            <ul id="tree1">
                                @foreach ($selectMenuItems as $selectMenuItem)
                                    <li><a href="{{ $selectMenuItem->url }}">{{ $selectMenuItem->name }}</a>
                                        @if ($selectMenuItem->children)
                                            <ul>
                                                @foreach ($selectMenuItem->children as $selectMenuChild)
                                                    <li><a href="{{ $selectMenuChild->url }}">{{ $selectMenuChild->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                    </div>

                </div>

        </div>
        </div>
    </main>
    <script>
        $.fn.extend({
            treed: function (o) {



                //initialize each of the top levels
                var tree = $(this);
                tree.addClass("tree");
                //fire event from the dynamically added icon

                //fire event to open branch if the li contains an anchor instead of text


            }
        });

        //Initialization of treeviews


        $('#tree1').treed({openedClass:'fa-minus', closedClass:'fa-plus'});


    </script>
</x-app-layout>
