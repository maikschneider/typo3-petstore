import {InputGuesser} from "@api-platform/admin";
import {useRecordContext} from "react-admin";
import {TcaImageField} from "./TcaImageField";

interface Props {
    source: string;

    [key: string]: unknown;
}

/**
* Drop-in replacement for InputGuesser that detects TYPO3 FileObject values
* and renders a read-only image preview instead of a broken text input.
*/
export const SmartInputGuesser = ({source, ...props}: Props) => {
    const record = useRecordContext();
    const value = record?.[source];

    if (
        value !== null &&
        value !== undefined &&
        typeof value === "object" &&
        !Array.isArray(value) &&
        "publicUrl" in value
    ) {
        return (
            <div style={{marginBottom: 16}}>
                <TcaImageField source={source} height={80} />
            </div>
        );
    }

    return <InputGuesser source={source} {...props} />;
};
