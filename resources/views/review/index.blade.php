@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>Reseñas</h2>
    <a href="{{ route('reviews.create') }}" class="btn">Registrar reseña</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Usuario</th>
                <th>Calificación</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['reviews'] as $review)
            <tr>
                <td>{{ $review->getProduct()->getName() }}</td>
                <td>{{ $review->getUser()->getName() }}</td>
                <td>{{ $review->getRating() }}/5</td>
                <td>{{ $review->getComment() ?? 'Sin comentario' }}</td>
                <td>{{ $review->getCreationDate() }}</td>
                <td>
                    <a href="{{ route('reviews.edit', ['id' => $review->getId()]) }}" class="btn">Editar</a>
                    <form action="{{ route('reviews.destroy', ['id' => $review->getId()]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #ef4444;">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['reviews']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">No hay reseñas registradas.</div>
    @endif
</div>
@endsection
