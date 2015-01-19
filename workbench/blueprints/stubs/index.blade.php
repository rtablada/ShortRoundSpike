@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><?= $title ?></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 index-actions">
                            <a class="btn btn-primary pull-right" href="<?= route('admin.{{ dashedPlural }}.create') ?>">Create {{ modelUpper }} <i class="fa fa-plus fa-lg"></i></a>
                        </div>
                    </div>

                    <table id="data-table" class="table table-striped table-bordered table-hover data-table">
                        <thead>
                            <tr>
                                {% for field in fields %}
{% if field.type matches '/file/' %}<th>{{ field.label }}</th>
{% else %}<th data-sort="{{ field.name }}">{{ field.label }}</th>{% endif %}

                                {% endfor %}

                                {% if position %}<th>Position</th>{% endif %}

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(${{ modelPlural }} as ${{ modelVar }})
                            <tr>
                                {% for field in fields %}
{% if field.type matches '/file/' %}<td><?php if (${{ modelVar }}->{{ field.name }}_file_name) : ?><img src="<?= ${{ modelVar }}->{{ field.name }}->url() ?>" alt=""/><?php endif ?></td>
{% else %}<td><?= ${{ modelVar }}->{{ field.name }} ?></td>{% endif %}

                                {% endfor %}

                                {% if position %}
<td>
                                    <?= ${{ modelVar }}->position ?>
                                    <a href="<?= URL::route('admin.{{ dashedPlural }}.up', ${{ modelVar }}) ?>">
                                        <i class="fa fa-lg fa-sort-up"></i>
                                    </a>
                                    <a href="<?= URL::route('admin.{{ dashedPlural }}.down', ${{ modelVar }}) ?>">
                                        <i class="fa fa-lg fa-sort-down"></i>
                                    </a>
                                </td>
                                {% endif %}

                                <td><a href="<?= URL::route('admin.{{ dashedPlural }}.edit', ${{ modelVar }}) ?>"><i class="fa fa-edit fa-lg"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin._partials.data-table')
