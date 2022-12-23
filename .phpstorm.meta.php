<?php

namespace PHPSTORM_META {

    // Allow PhpStorm IDE to resolve return types when calling app(ObjectType::class) or app(`Object_Type`).
    override(
        \app(0),
        map([
            '' => '@',
            '' => '@Class',
        ])
    );
}
