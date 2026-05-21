import { useRecordContext } from "react-admin";

interface FileObject {
publicUrl: string;
mimeType?: string;
fileSize?: number;
cropVariants?: Record<string, { publicUrl: string; width?: number; height?: number }>;
}

interface TcaImageFieldProps {
source: string;
height?: number;
label?: string;
}

/**
* Renders a TYPO3 ImageProcessor FileObject as an <img>.
* Falls back to the raw publicUrl when no default cropVariant exists.
*/
export const TcaImageField = ({ source, height = 60 }: TcaImageFieldProps) => {
const record = useRecordContext();
if (!record) return null;

const file = record[source] as FileObject | null | undefined;
if (!file?.publicUrl) return null;

const src =
    file.cropVariants?.default?.publicUrl ??
    file.cropVariants?.[Object.keys(file.cropVariants)[0]]?.publicUrl ??
    file.publicUrl;

const base = window.location.origin + "/";
const url = src.startsWith("http") ? src : base + src;

return (
    <a href={url} target="_blank" rel="noreferrer">
    <img src={url} alt="" height={height} style={{ objectFit: "cover", borderRadius: 4 }} />
    </a>
);
};
