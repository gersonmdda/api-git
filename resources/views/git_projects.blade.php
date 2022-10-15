@extends('layout.layout')
<div>
    <h1>Projetos Git Hub</h1>
</div>
<div>
  <form action="/">
      <h2>Filtros</h2>
      <div>
        <div class='row'>
          <div class="form-group col-sm-3">
            <label for="name">Nome:   </label>
            <input value="{{@$name}}" name="name" type="text" class="form-control" id="text">
          </div>
          <div class="form-group col-sm-3">
            <label for="language">Linguagem:</label>
            <input value="{{@$filters['language']}}" name="language" type="text" class="form-control" id="language">
          </div>
          <div class="form-group col-sm-3">
            <label for="size">Tamanho:</label>
            <input value="{{@$filters['size']}}" name="size" type="number" class="form-control" id="size">
          </div>
          <div class="form-group col-sm-3">
            <label for="archived">Arquivado:</label>
            <select name="archived" class="form-control" id="sel1">
              <option @if(@$filters['archived'] == 2) selected @endif value="2" >selecione</option>
              <option @if(@$filters['archived'] == 0) selected @endif value="0">não</option>
              <option @if(@$filters['archived'] == 1) selected @endif value="1">sim</option>
            </select>
          </div>
        </div>
        <div class='row'>
          <button type="submit" class="btn btn-default">Filtrar</button>
        </div>
      </div>
      <div class="container">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> <input value="Nome" name="sort" class="btn btn-default" type="submit" >  </th>
                <th> <input value="Data do Commit" name="sort" class="btn btn-default" type="submit" >  </th>
                <th>Linguagem</th>
                <th>Tamanho</th>
                <th>Arquivado</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($repositories as $repository)
                <tr>
                  <td>{{$repository->full_name}}</td>
                  <td>{{$repository->last_commit_date_br}}</td>
                  <td>{{$repository->language}}</td>
                  <td>{{$repository->size}}</td>
                  <td>{{$repository->archived ? 'Sim' : 'Não'}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>
  </form>
</div>