{{--  Esteban Alvarez Garcia  --}}
@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
<div class="title-section">
    <h2>{{ __('messages.reviews_title') }}</h2>
    <a href="{{ route('review.create') }}" class="btn">{{ __('messages.review_create_title') }}</a>
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
                <td>{{ $review->getComment() ?? __('messages.no_comment') }}</td>
                <td>{{ $review->getCreatedAt() }}</td>
                <td>
                    <div class="actions-row">
                        <a href="{{ route('review.edit', ['id' => $review->getId()]) }}" class="btn btn-sm btn-secondary">{{ __('messages.btn_edit') }}</a>
                        <form action="{{ route('review.destroy', ['id' => $review->getId()]) }}" method="POST" class="form-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.btn_delete') }}</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($viewData['reviews']->total() === 0)
        <div class="es-80f9a287">{{ __('messages.no_reviews') }}</div>
    @elseif ($viewData['reviews']->hasPages())
        <div class="pagination-wrapper">
            {{ $viewData['reviews']->links() }}
        </div>
    @endif
</div>
@endsection
