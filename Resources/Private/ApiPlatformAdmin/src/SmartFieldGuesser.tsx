import { FieldGuesser } from "@api-platform/admin";
import { useRecordContext } from "react-admin";
import { TcaImageField } from "./TcaImageField";

interface Props {
  source: string;
  [key: string]: unknown;
}

/**
 * Drop-in replacement for FieldGuesser that detects TYPO3 FileObject values
 * (shape: { publicUrl, mimeType?, ... }) and renders TcaImageField instead of
 * the default [object Object] text rendering.
 */
export const SmartFieldGuesser = ({ source, ...props }: Props) => {
  const record = useRecordContext();
  const value = record?.[source];

  if (
    value !== null &&
    value !== undefined &&
    typeof value === "object" &&
    !Array.isArray(value) &&
    "publicUrl" in value
  ) {
    return <TcaImageField source={source} height={48} />;
  }

  return <FieldGuesser source={source} {...props} />;
};
