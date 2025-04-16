<?php

namespace Picturium;

class UrlGenerator
{
    private Picturium $picturium;

    public function __construct(Picturium $picturium)
    {
        $this->picturium = $picturium;
    }

    /**
     * @param array<int,mixed> $data
     */
    public function generateUrl(array $data): string
    {
        $urlParams = [];
        $instance = $this->picturium->getInstance();

        $src = $data["src"] ?? $this->picturium->getSrc();
        unset($data["src"]);

        ksort($data);

        foreach ($data as $parameter => $value) {
            if (empty($value)) {
                continue;
            }

            if (is_array($value)) {
                $processed = $this->{$parameter}($value);
                $result = [];

                foreach ($processed as $key => $val) {
                    $result[] = $key . ":" . $val;
                }

                $urlParams[$parameter] = implode(",", $result);
            } else {
                $urlParams[$parameter] = $value;
            }
        }

        if (isset($urlParams["original"]) && $urlParams["original"]) {
            $urlParams = ["original" => "true"];
        } else {
            unset($urlParams["original"]);
        }

        if (strpos($src, $instance["url"]) === 0) {
            $src = mb_substr($src, mb_strlen($instance["url"]));
        }

        $src = explode("?", $src)[0];
        $src = trim($src, " /");

        $urlString = $src . "?" . urldecode(http_build_query($urlParams));

        $instanceUrl = trim($instance["url"], " /");

        if (!empty($instance["token"])) {
            $token = hash_hmac("sha256", $urlString, $instance["token"]);
            return $instanceUrl . "/" . $urlString . (str_ends_with($urlString, "?") ? "" : "&") . "token=" . $token;
        }

        return trim($instanceUrl . "/" . $urlString, " ?");
    }

    /**
     * @param array<int,mixed> $value
     * @return array|array<string,mixed>
     */
    protected function crop(array $value): array
    {
        $result = [];

        if (!empty($value["width"])) {
            $result["w"] = $value["width"];
        }

        if (!empty($value["height"])) {
            $result["h"] = $value["height"];
        }

        if (!empty($value["aspectRatio"])) {
            $result["ar"] = $value["aspectRatio"];
        }

        if (!empty($value["gravity"])) {
            $result["g"] = $value["gravity"];
        }

        if (!empty($value["offsetX"])) {
            $result["x"] = $value["offsetX"];
        }

        if (!empty($value["offsetY"])) {
            $result["y"] = $value["offsetY"];
        }

        return $result;
    }

    /**
     * @param array<int,mixed> $value
     * @return array|array<string,mixed>
     */
    protected function load(array $value): array
    {
        $result = [];

        if (!empty($value["dpi"])) {
            $result["dpi"] = $value["dpi"];
        }

        return $result;
    }

    /**
     * @param array<int,mixed> $value
     * @return array|array<string,mixed>
     */
    protected function thumb(array $value): array
    {
        $result = [];

        if (!empty($value["page"])) {
            $result["p"] = $value["page"];
        }

        return $result;
    }
}
