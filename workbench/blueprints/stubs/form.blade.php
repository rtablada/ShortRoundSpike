@extends('admin.layouts.sb-wrapper')

@section('page')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><?= $title ?></div>
                <div class="panel-body">
                    <form class="form" action="<?= $route ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>"/>
                        @if ($method)
                            <input type="hidden" name="_method" value="<?= $method ?>"/>
                        @endif

                        <fieldset>
                            {% for field in fields %}{% if field.type matches '/boolean/' %}<div class="form-group<?= $errors->first('{{ field.name }}', ' has-error') ?>">

                                <label for="{{ field.name }}" class="control-label">{{ field.label }}</label>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="{{ field.name }}" id="{{ field.name }}" <?= ${{ modelVar }}->{{ field.name }} ? 'checked' : null ?> value="1"> {{ field.label }}
                                    </label>
                                </div>

                                <span class="help-block"><?= $errors->first('{{ field.name }}') ?></span>

                            </div>
                            {% elseif field.type matches '/file/' %}<div class="form-group<?= $errors->first('{{ field.name }}', ' has-error') ?>">

                                <label for="{{ field.name }}" class="control-label">{{ field.label }}</label>

                                <input type="file" class="form-control image-preview-input" name="{{ field.name }}" id="{{ field.name }}">

                                <span class="existing-image" data-preview="{{ field.name }}">
                                    @if (${{ modelVar }}->{{ field.name }}_file_name)
                                        <img src="<?= ${{ modelVar }}->{{ field.name }}->url() ?>"/>
                                    @else
                                        <p>No {{ field.name }} is uploaded</p>
                                    @endif
                                </span>

                                <span class="help-block"><?= $errors->first('{{ field.name }}') ?></span>

                            </div>
                            {% elseif field.type matches '/text/' %}<div class="form-group<?= $errors->first('{{ field.name }}', ' has-error') ?>">

                                <label for="{{ field.name }}" class="control-label">{{ field.label }}</label>

                                <textarea type="text" class="form-control" name="{{ field.name }}" id="{{ field.name }}" placeholder="{{ field.label }}">
                                    <?= old('{{ field.name }}', ${{ modelVar }}->{{ field.name }}) ?>
                                </textarea>

                                <span class="help-block"><?= $errors->first('{{ field.name }}') ?></span>

                            </div>
                            {% else %}<div class="form-group<?= $errors->first('{{ field.name }}', ' has-error') ?>">

                                <label for="{{ field.name }}" class="control-label">{{ field.label }}</label>

                                <input type="text" class="form-control" name="{{ field.name }}" id="{{ field.name }}" placeholder="{{ field.label }}" value="<?= old('{{ field.name }}', ${{ modelVar }}->{{ field.name }}) ?>">

                                <span class="help-block"><?= $errors->first('{{ field.name }}') ?></span>

                            </div>
                            {% endif %}

                            {% endfor %}

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="actions pull-right">
                                        <a class="btn btn-default" href="<?= URL::route('admin.{{ dashedPlural }}.index') ?>">Back</a>
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
