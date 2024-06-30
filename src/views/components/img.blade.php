<img src="{{ url(((is_array($img) ? $img['url'] : $img)?:null) ?? 'mantis/images/dummy.jpg') }}" alt="{{ $img['alt'] ?? '' }}" @class($class) onerror="this.src=url('mantis/images/dummy.jpg')">
