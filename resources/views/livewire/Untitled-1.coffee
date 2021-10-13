

                        <div class="block mt-4">
                            <label for="approvalRight" class="flex items-center">
                                <x-jet-checkbox id="approvalRight" name="approvalRight" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Approval Right') }}</span>
                            </label>
                        </div>

                        @if ($item->id == auth()->user()->department_id) selected @endif
                        @if ($item->id == auth()->user()->category_id) selected @endif 