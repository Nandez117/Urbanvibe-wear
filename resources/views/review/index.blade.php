{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.reviews_title') }}</h2>
    <a href="{{ route('reviews.create') }}" class="btn">{{ __('messages.review_create_title') }}</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>{{ __('messages.lbl_product') }}</th>
                <th>{{ __('messages.lbl_user') }}</th>
                <th>{{ __('messages.lbl_rating') }}</th>
                <th>{{ __('messages.lbl_comment') }}</th>
                <th>{{ __('messages.lbl_date') }}</th>
                <th>{{ __('messages.lbl_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($viewData['reviews'] as $review)
            <tr>
                <td>{{ $review->getProduct()->getName() }}</td>
                <td>{{ $review->getUser()->getName() }}</td>
                <td>{{ $review->getRating() }}/5</td>
                <td>{{ $review->getComment() ?? 'Sin comentario' }}</td>
                <td>{{ $review->getCreatedAt() }}</td>
                <td>
                    <a href="{{ route('reviews.edit', ['id' => $review->getId()]) }}" class="btn">{{ __('messages.btn_edit') }}</a>
                    <form action="{{ route('reviews.destroy', ['id' => $review->getId()]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background-color: #ef4444;">{{ __('messages.btn_delete') }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if (count($viewData['reviews']) === 0)
        <div style="padding: 2rem; text-align: center; color: var(--text-gray);">{{ __('messages.no_reviews') }}</div>
    @endif
</div>
@endsection
