update maps_markers set
    latitude = (80 + (id/50) + (id/250)),
    longitude = (-177 + (-1*id/50) + (-1*id/250))
    where latitude = 0
;

update maps_routes set
    coordinates =
    CONCAT(
        "[",
            '{',
                '"lat":', ( 50 + (id/50) + (id/250) ),
                ',',
                '"lng":', (-170 + (-1*id/50) + (-1*id/250) ),
            '},',
            '{',
                '"lat":', ( 51 + (id/50) + (id/250) ),
                ',',
                '"lng":', (-167.5 + (-1*id/50) + (-1*id/250) ),
            '}',
        "]"
    )
    where coordinates = '[{"lat":"0","lng":"0"}]' or distance = '0'
;

update maps_zones set
    coordinates =
    CONCAT(
        "[",
            '{',
                '"lat":', ( 60 + (id/50) + (id/250) ),
                ',',
                '"lng":', (-170 + (-1*id/50) + (-1*id/250) ),
            '},',
            '{',
                '"lat":', ( 61 + (id/50) + (id/250) ),
                ',',
                '"lng":', (-167.5 + (-1*id/50) + (-1*id/250) ),
            '},',
            '{',
                '"lat":', ( 62 + (id/50) + (id/250) ),
                ',',
                '"lng":', (-170 + (-1*id/50) + (-1*id/250) ),
            '}',
        "]"
    )
    where coordinates = '' or coordinates = '[]'
;
