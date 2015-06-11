update maps_markers set latitude = (80 + (id/50) + (id/250)), longitude = (-177 + (-1*id/50) + (-1*id/250)) where latitude = 0;
