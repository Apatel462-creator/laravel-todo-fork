<div class="mb-3">
    <label class="form-label">Title</label>

    <input
        type="text"
        name="title"
        class="form-control"
        value="{{ old('title', $todo->title ?? '') }}"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>

    <textarea
        name="description"
        class="form-control"
        rows="4">{{ old('description', $todo->description ?? '') }}</textarea>
</div>

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Status</label>

        <select name="status" class="form-select">

            @foreach([
            'pending',
            'in_progress',
            'completed',
            'cancelled'
            ] as $status)

            <option
                value="{{ $status }}"
                @selected(old('status', $todo->status ?? '') == $status)
                >
                {{ ucfirst($status) }}
            </option>

            @endforeach

        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Priority</label>

        <select name="priority" class="form-select">

            @foreach([
            'low',
            'medium',
            'high',
            'urgent'
            ] as $priority)

            <option
                value="{{ $priority }}"
                @selected(old('priority', $todo->priority ?? '') == $priority)
                >
                {{ ucfirst($priority) }}
            </option>

            @endforeach

        </select>
    </div>

</div>

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Due Date</label>

        <input
            type="date"
            name="due_date"
            class="form-control"
            value="{{ old('due_date', $todo->due_date ?? '') }}">
    </div>

</div>

<button class="btn btn-primary">
    Submit
</button>